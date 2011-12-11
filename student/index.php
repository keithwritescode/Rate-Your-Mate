<?php include ("../includes/check_authorization.php");
error_reporting(-1);


include ( "../includes/config.php" );
include ( "../includes/opendb.php" );

$userID = $_SESSION['userID'];

// If the project was changed load the new team list into the session
if ( !empty( $_POST['projectSelect'] ) && $_POST['projectSelect'] != $_SESSION['prjID'] ) {
	$_SESSION['prjID'] = $_POST['projectSelect'];
	
	// Get the group the student is in for the group
	$groupIDQueryString = 'SELECT G.GrpID FROM Groups G WHERE G.StudentID = ' . $userID . ' AND G.PrjID = ' . $_SESSION['prjID'] . ';';
	$groupIDQuery = mysql_query ( $groupIDQueryString );
	if ( $groupIDQuery ) {
		$groupID = mysql_fetch_array ( $groupIDQuery );
		$_SESSION['groupID'] = $groupID['GrpID'];
	}
	else $_SESSION['groupID'] = 0;

	// Get all members of the group
	$groupListQueryString = 'SELECT G.StudentID FROM Groups G WHERE G.GrpID = ' . $_SESSION['groupID'] . ';';
	$groupListQuery = mysql_query ( $groupListQueryString );
	
	
	// empty the current list
	unset ( $_SESSION['groupList'] );
	$_SESSION['groupList'] = array();
	
	if( $groupListQuery ) {
		$cnt = 0;
		while ( $row = mysql_fetch_array( $groupListQuery ) ) {
			// Initialize the array if necessary
			if ( $cnt++ == 0 )
				$_SESSION['groupList'] = array ( array( 'studentID' => $row['StudentID'] ) );
			else
				array_push( $_SESSION['groupList'], array( 'studentID' => $row['StudentID'] ) );	
		}
	}
}
	
// Get an array of all projects the student is working on
$projectQueryString = 'SELECT G.PrjID, P.PrjName 
	FROM Groups G, Project P WHERE G.PrjID = P.PrjID AND G.StudentID = ' . $userID . ';';
$projectQuery = mysql_query ( $projectQueryString );

$project = array();

if ( $projectQuery ) {
	$numProjects = mysql_num_rows( $projectQuery ); 
}
else $numProjects = -1;

// Initialize a count to help with array creation
$cnt = 0;
if ( $numProjects > 0 ) {
	// Create an array of projects this student is working on
	while ( $row = mysql_fetch_array( $projectQuery ) ) {
		$project[$cnt]['prjID'] = $row['PrjID'];
		$project[$cnt]['prjName'] = $row['PrjName'];
		// Set aside the name of the current project
		if ( !empty( $_SESSION['prjID'] ) && $project[$cnt]['prjID'] == $_SESSION['prjID'] )
				$prjName = $project[$cnt]['prjName'];
		// Increment the count for the array
		$cnt++;
	}
	if ( empty ( $_SESSION['prjID'] ) )
		$_SESSION['prjID'] = $project[0]['prjID'];
	
	
	$projResult = mysql_query ("SELECT  CourseID FROM Project WHERE PrjID = ".$_SESSION['prjID']." ;");
	if ( $projResult ) {
		$row = mysql_fetch_assoc( $projResult );
		$_SESSION['crsID'] = $row['CourseID'];  
	} else $_SESSION['crsID'] = 0;

	// Get the course roster
	$result = mysql_query ("SELECT u.firstname, u.lastname, u.id FROM mdl_course c 
							LEFT OUTER JOIN mdl_context cx ON c.id = cx.instanceid 
							LEFT OUTER JOIN mdl_role_assignments ra ON cx.id = ra.contextid 
							AND ra.roleid = '5' 
							LEFT OUTER JOIN mdl_user u ON ra.userid = u.id 
							WHERE cx.contextlevel = '50' AND c.id= " . $_SESSION['crsID'] );
	$_SESSION['roster'] = array();
	if ( $result ) {
		$i = 0;
		unset( $_SESSION['roster'] );
		// Put the roster into an array in the session
		while ( $row = mysql_fetch_assoc( $result ) ) {
			if ( !empty( $_SESSION['roster'] ) ) {
				$_SESSION['roster'] += array($i => array("name" => ($row['firstname'] . " " . $row['lastname']), "id" => $row['id']));
			}
			else {			
				$_SESSION['roster'] = array( array("name" => ($row['firstname'] . " " . $row['lastname']), "id" => $row['id']));
			}
			$i++;
		}
	}
	// Get a list of students in the group based on the roster
	// Get the ID's of all group members
	unset( $_SESSION['group'] );
	$groupSdtIDQueryString = ( 'SELECT G.StudentID FROM Groups G WHERE G.GrpID = ' . $_SESSION['groupID'] ); 
	$groupSdtIDQuery = mysql_query( $groupSdtIDQueryString ) or die( 'Could not retrieve the list of group members' );

	while ( $studentID = mysql_fetch_assoc( $groupSdtIDQuery ) ) {
		foreach ( $_SESSION['roster'] as $student ) {
			if ( $student['id'] == $studentID['StudentID'] ) 
				$_SESSION['group']['id'] = $student['name'];
		}
	}
	
	
}
else $_SESSION['prjID'] = -1;

?>

<html>
<head>
    <title> Student Home </title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
    <link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
        <div id="message">
                <?php
                if ( !empty( $_POST['message'] ) )
                        echo '<p>' . $_POST['message'] . '</p>';
                ?>
        </div>
        <div id="header">
                <h1> Student Home </h1>
        </div>
        <div id="menu">
                <?php include ("../includes/student_menu.php"); ?>
        </div>

        <div id="content">
            <div id="projectSelect">
                <form id='projectForm' name="instructorHome"
					action="index.php" method="post" >
			
					<?php
					if ( !empty( $prjName ) ) {
						echo '<p> Project ' . $prjName . ' selected, change project? </p>';
					}
					else if ( $numProjects == 0 ) {
						echo '<p> You are currently not in any projects! </p>';
					}
					else {
						echo '<p> Select a project to begin </p>';
					}
					?>
					<select id='projectSelect' name='projectSelect' 
						<?php if( $numProjects == 0 ) echo 'disabled="disabled"'; ?>
						onchange='this.form.submit()'>
						<?php // Compile a list of all projects for this class
						foreach ( $project as $prj ) {
							print_r ($prj);
							if ( $prj['prjID'] == $_SESSION['prjID'] )
									$defaultString = 'selected="selected"';
							else $defaultString = '';
							echo '<option value="' . $prj['prjID'] . '" ' . $defaultString . '>' . $prj['prjName'] . ' </option>';
						}
						if ( empty ( $_SESSION['prjID'] ) )
								echo '<option selected="selected"> Select a project </option>';
						?>
					</select>

				</form>
				<input id='submit' type="submit" style="visibility:hidden" />

                </div>
        </div>
</body>
</html>
