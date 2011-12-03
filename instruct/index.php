<?php include ("../includes/check_authorization.php");
error_reporting(-1);

include ( "../includes/config.php" );
include ( "../includes/opendb.php" );

if ( !empty( $_POST['classSelect'] ) ) {
	if ( $_SESSION['crsID'] != $_POST['classSelect'] ) {
		$_SESSION['crsID'] = $_POST['classSelect'];
		// Unset the project
		unset( $_SESSION[ 'prjID' ] );
	}
	else if ( !empty ( $_POST['projectSelect'] ) ) {
		$_SESSION['prjID'] = $_POST['projectSelect'];
	}
}

// Get the roster for the class selected and store it into roster of session
if ( empty( $_SESSION['crsID'] ) )
	$_SESSION['crsID'] = 1;

// Get all the projects assocated with the current class
if ( !empty( $_SESSION['crsID'] ) ) {
	$projectQueryString = ('SELECT P.PrjID, P.PrjName FROM Project P WHERE P.CourseID = ' . $_SESSION['crsID'] . ';' );
	$projectQuery = mysql_query ( $projectQueryString );
	$cnt=0;

	// Create an array of projects associated with this course
	while ( $row = mysql_fetch_array( $projectQuery ) ) {	
		$project[$cnt]['prjID'] = $row['PrjID'];
		$project[$cnt]['prjName'] = $row['PrjName'];
		
		// Set the project if there is none
		if ( empty ( $_SESSION['prjID'] ) ) {
			$_SESSION['prjID'] = $project[0]['prjID'];
			$prjName = $project[0]['prjName'];
		}
			
		// Set aside the name of the current project
		if ( !empty( $_SESSION['prjID'] ) && $project[$cnt]['prjID'] == $_SESSION['prjID'] ) 
			$prjName = $project[$cnt]['prjName'];
		$cnt++;
	}

	// Get the course roster
	$result = mysql_query ("SELECT DISTINCT a.roleid as roleid, b.id as id, b.firstname as firstname, b.lastname as lastname 
							FROM mdl_role_assignments a, mdl_user b, mdl_course c 
							WHERE a.roleid=5 AND a.userid=b.id AND c.id = " . $_SESSION['crsID'] . ';'); 
	$i = 0;
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
?>
<html>
<head>
    <title> Instructor Home </title>
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
		<h1> Instructor Home </h1>
	</div>
	<div id="menu">
		<?php include ("../includes/instruct_menu.php"); ?>
	</div>

	<div id="content">	
		<div id="projectSelect">
			<form id='projectForm' name="instructorHome"
				action="index.php" method="post" >
			<?php			
			echo '<p> Class ' . $_SESSION['crsID'] . ' is selected, change course? </p>';
			?>
			<select id='classSelect' name='classSelect' onchange='this.form.submit()'>
				<?php
				for ( $i = 1; $i <= 2; $i++ ) {
					if ( $i == $_SESSION['crsID'] )
						$defaultString = 'selected="selected"';
					else $defaultString = '';
					echo '<option value="' . $i . '" ' . $defaultString . '> Course ' . $i . '</option>';
				}
				?>
			</select>
			<?php
			if ( !empty( $prjName ) ) { 
				echo '<p> Project ' . $prjName . ' selected, change project? </p>';
			}
			else {
				echo '<p> Select a project or create a new one to begin </p>';
			}
			?>
			<select id='projectSelect' name='projectSelect' onchange='this.form.submit'
				<?php if ( empty( $_SESSION['crsID'] ) )
					echo 'disabled="disabled"'; ?> >
				<?php // Compile a list of all projects for this class
				foreach ( $project as $prj ) {
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
