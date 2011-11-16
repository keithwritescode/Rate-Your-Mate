<?php include ("../includes/check_authorization.php");
error_reporting(-1);

// Connect to the database
include ("../includes/config.php");
include ("../includes/opendb.php");

// Brought in from POST/SESSION
$studentID = 4;
// Brought in through POST
$prjID = 72;

// Get student list for the project
$groupQueryString = ("SELECT G.StudentID
	       FROM Groups G
	       WHERE G.GrpID = ( SELECT G1.GrpID
	         	FROM Groups G1 WHERE StudentID ='$studentID')
		   AND G.StudentID !='$studentID' AND G.PrjID = '$prjID';" );

// Get the behavior list
$behaviorQuery = mysql_query ( "SELECT B.Description
				FROM Behaviors B
				WHERE B.PrjID = '$prjID' 
				AND B.GrpID = ( SELECT G.GrpID FROM
					Groups G WHERE G.StudentID = '$studentID');") or die(mysql_error());
// ***************************** DELETE WHEN IT WORKS		


// ***************************** DELETE WHEN IT WORKS	

?>


<html>
	<head>
		<title>Rate Your Mate</title>
		

	</head>
<body>

<div id="header">
	<h2>Student Input</h2>
</div>

<div id="menu">
	<?php include ("../includes/menu.php"); ?>
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
		$behaviorCnt = 1;
		// Go through each behavior
		while ( $brow = mysql_fetch_array( $behaviorQuery ) ) {
			// Put in the header
			echo '<div class="behavior">';
			echo '<h3> Behavior ' . $behaviorCnt . '</h3>';
			echo '<p> ' . $brow['Description'] . '</p>';
			$studentCnt = 1;
			$groupQuery = mysql_query ( $groupQueryString );
			// List a box for each student in the group
			while ( $srow = mysql_fetch_array( $groupQuery ) ) {
				echo '<h5> Student Name goes here ' . $studentCnt . '</h5>';
				echo '<textarea name=student['.$srow['StudentID'].']['.$behaviorCnt.']
					rows="5" cols="50">Student ID '.$srow['StudentID'].'</textarea>';
				$studentCnt++;
			}
			$behaviorCnt++;
			echo '</div>';
		}


		?>
		<div id="piechart" >
			<h4> Overall </h4>
			<textarea rows="5" cols="50">Holder for Pie Chart!!1!1</textarea>
		</div>
		<input type="submit" value="Submit" />
	</form>
</body>
</html>	
