<?php include ("../includes/check_authorization.php");
error_reporting(-1);


include ( "../includes/config.php" );
include ( "../includes/opendb.php" );
$userID = 8;
$_SESSION['userID'] = $userID;

// If the project was changed load the new team list into the session
if ( !empty( $_POST['projectSelect'] ) && $_POST['projectSelect'] != $_SESSION['prjID'] ) {
	$_SESSION['prjID'] = $_POST['projectSelect'];
	
	// Get the group the student is in for the group
	$groupIDQueryString = 'SELECT G.GrpID FROM Groups G WHERE G.StudentID = ' . $userID . ' AND G.PrjID = ' . $_SESSION['prjID'] . ';';
	$groupIDQuery = mysql_query ( $groupIDQueryString );
	$groupID = mysql_fetch_array ( $groupIDQuery );
	$_SESSION['groupID'] = $groupID['GrpID'];

	// Get all members of the group
	$groupListQueryString = 'SELECT G.StudentID FROM Groups G WHERE G.GrpID = ' . $_SESSION['groupID'] . ';';
	$groupListQuery = mysql_query ( $groupListQueryString );
	
	// empty the current list
	unset ( $_SESSION['groupList'] );

	$cnt = 0;
	while ( $row = mysql_fetch_array( $groupListQuery ) ) {
		// Initialize the array if necessary
		if ( $cnt++ == 0 )
			$_SESSION['groupList'] = array ( array( 'studentID' => $row['StudentID'] ) );
		else
			array_push( $_SESSION['groupList'], array( 'studentID' => $row['StudentID'] ) );	
	}
}
	
// Get an array of all projects the student is working on
$projectQueryString = 'SELECT G.PrjID, P.PrjName 
	FROM Groups G, Project P WHERE G.PrjID = P.PrjID AND G.StudentID = ' . $userID . ';';
$projectQuery = mysql_query ( $projectQueryString );
// Initialize a count to help with array creation
$cnt = 0;
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
					else {
						echo '<p> Select a project to begin </p>';
					}
					?>
					<select id='projectSelect' name='projectSelect' onchange='this.form.submit()'>
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
