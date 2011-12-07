<?php include ("../includes/check_authorization.php");
error_reporting(-1);

// Connect to the database
include ("../includes/config.php");
include ("../includes/opendb.php");

// Brought in from POST/SESSION
$studentID = 4;
// Brought in through POST
$prjID = $_SESSION['prjID'];

// Get the behavior list
$behaviorQuery = mysql_query( 'SELECT B.BehaviorID, B.Description
				FROM Behaviors B
				WHERE B.GrpID = ' . $_SESSION['groupID'] . ';');	

?>


<html>
<head>
	<title>Rate Your Mate</title>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>

<div id="header">
	<h1>Student Input</h1>
</div>

<div id="menu">
	<?php include ("../includes/student_menu.php"); ?>
</div>

<div id="content">
	<div name="inputTitle">
		<h3>Student Input</h3>
		</br>
		<p>Please evaluate your group members on each behavior in your contract.</p>
		</br>
	</div>

	<form action="submitStudentInput.php" method="POST"> 
	
		<?php

		$projResult = mysql_query ("SELECT  CourseID FROM Project WHERE PrjID = ".$prjID." ;");

		while($row = mysql_fetch_array($projResult))
  {
  $_SESSION['crsID'] = $row['CourseID'];
  
  }

		 $result = mysql_query ("SELECT DISTINCT a.roleid as roleid, b.id as
 id, b.firstname as firstname, b.lastname as lastname FROM mdl_role_assignments a, mdl_user b, mdl_course c
                                              WHERE a.roleid=5 AND a.userid=b.id AND c.id = " . $_SESSION['crsID'] . ';');
        $i = 0;

	

        // Put the roster into an array in the session
        while ( $row = mysql_fetch_assoc($result) ) {
                if ( !empty( $_SESSION['roster'] ) ) {
                        $_SESSION['roster'] += array($i => array("name" =>($row['firstname'] . " " . $row['lastname']), "id" => $row['id']));
                }
                else {
                        $_SESSION['roster'] = array( array("name" => ($row['firstname'] . " " . $row['lastname']), "id" => $row['id']));
                }
                $i++;
        }



		$behaviorCnt = 1;
		// Go through each behavior
		while ( $row = mysql_fetch_array( $behaviorQuery ) ) {
			// Put in the header
			echo '<div class="behavior">';
			echo '<h3> Behavior ' . $behaviorCnt . '</h3>';
			echo '<p> ' . $row['Description'] . '</p>';
			$studentCnt = 1;

			echo '<div class="ac" >';
			// List a box for each student in the group
			foreach ( $_SESSION['groupList'] as $student ) {
// LINE TO PRINT STUDENT NAMES TO BOXES				echo '<h3> <a href="#"> '  . $roster['name'] . '</a></h3>';
				echo '<div><textarea name=student['.$student['studentID'].']['.$behaviorCnt.']
					rows="5" cols="50">Student ID '.$student['studentID'].'</textarea></div>';
			}
			$behaviorCnt++;
			echo '</div> </div>';
		}
		?>

		<div id="piechart" >
			<h4> Overall </h4>
			<p>Holder for Pie Chart!!1!1</p>
		</div>
		<input type="submit" value="Submit" />
	</form>
</body>

<script>
	$(function() {	
		$( ".ac" ).accordion({
			autoHeight: false,
			navigation: true	
		});
	
	});
</script>
</html>	
