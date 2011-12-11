<?php include ("../includes/check_authorization.php");
error_reporting(-1);

// Connect to the database
include ("../includes/config.php");
include ("../includes/opendb.php");

// Brought in from POST/SESSION
$studentID = $_SESSION['userID'];
// Brought in through POST
$prjID = $_SESSION['prjID'];

// Get the behavior list
$behaviorQuery = mysql_query( 'SELECT B.BehaviorID, B.Description
				FROM Behaviors B
				WHERE B.GrpID = ' . $_SESSION['groupID'] . ';') or die ( 'ERROR: Could not find group id' );	

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
			foreach ( $_SESSION['group'] as $id => $name ) {
				if ( $id != $_SESSION['userID'] ) {
					// LINE TO PRINT STUDENT NAMES TO BOXES				
					echo '<h3> <a href="#"> '  . $name . '</a></h3>';
						echo '<div><textarea name=student['.$id.']['.$behaviorCnt.']
							rows="5" cols="50">Student ID '.$id.'</textarea></div>';
					}
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
