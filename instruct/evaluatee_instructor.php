<?php include ("../includes/check_authorization.php");
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");
$prjID = $_SESSION['prjID'];

// Assign the current group
if ( !empty( $_POST['groupID'] ) )
	$_SESSION['groupID'] = $_POST['groupID'];
	

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />		
	<title>Rate Your Mate</title>
</head>

<body>
<div id="header">
	<h1>Instructor Evaluation</h1>
</div>

<div id="menu">
	<?php include ("../includes/instruct_menu.php"); ?>
</div>


<div id="content">
			<?php
			// Get all groups for this project
			$groupIDQuery = mysql_query ( " SELECT DISTINCT G.GrpID FROM Groups G WHERE
                                G.PrjID = ".$prjID);
			$cnt = 1;
			?>
			
			<form id='groupSelectForm' name='form' action="evaluatee_instructor.php" method="post">
			<select name="groupID" onchange='this.form.submit()'>
			
			<?php
			while ( $groupID = mysql_fetch_array ( $groupIDQuery ) ) {
				$groupIDArr[$cnt] = $groupID['GrpID'];
				if ( $_SESSION['groupID'] == $groupID['GrpID'] )
					$defaultString = 'selected="selected"';
				else $defaultString = '';
				if ( empty( $_SESSION['groupID'] ) ) 
					$_SESSION['groupID'] = $groupID['GrpID'];
				echo '<option value="' . $groupID['GrpID'] . '" ' . $defaultString . '> Team ' . $cnt++ . '</option>';
			}			
			?> 
			</select>
			</form>
	<h4><p>Below are evaluations of group members each based on behaviors in their contract.</p></h4>

	<?php			
	// Get the ID's of all group members
	$groupSdtIDQueryString = ( 'SELECT G.StudentID FROM Groups G WHERE G.GrpID = ' . $_SESSION['groupID'] ); 
	$groupSdtIDQuery = mysql_query( $groupSdtIDQueryString );
	$cnt = 0;
	while ( $studentID = mysql_fetch_array( $groupSdtIDQuery ) ) {
		foreach ( $_SESSION['roster'] as $student ) {
			if ( $student['id'] == $studentID['StudentID'] ) {
				$groupArr[$cnt++] = array( 'name' => $student['name'], 'id' => $student['id'] );
				echo '<li>' . $student['name'] . '</li>';
			}
		}
	}
	
	// Get all the behaviors the group has
	$behaviorQueryString = ( 'SELECT B.BehaviorID, B.Description
		FROM Behaviors B
		WHERE B.GrpID = ' . $_SESSION['groupID'] . ';');
	$behaviorQuery = mysql_query( $behaviorQueryString );
	// Put into an array
	$cnt = 0;
	while ( $studentID = mysql_fetch_array( $behaviorQuery ) ) {
		$behaviorArr[ $studentID['BehaviorID'] ] = $studentID['Description'];
	}

	// For each student post all comments and their source
	foreach ( $groupArr as $student ) {
		// Get all comments related to this student for this project	
		$commentQueryString = 'SELECT C.SrcId, C.Comment, C.BehaviorId FROM Comments C 
			WHERE C.PrjID = ' . $_SESSION['prjID'] . ' AND C.SrcId = ' . $student['id'] . 'ORDER BY C.BehaviorId;';
		$commentQuery = mysql_query( $commentQueryString );
		
		// Print out the behavior
		$cnt = 0;
		while ( $comment = mysql_fetch_array( $commentQuery ) ) {
			// If this is the first for this behavior, create a header
			if ( empty( $currBehavior ) || $currBehavior != $comment['BehaviorID'] ) {
				echo '<h4> ' . $behaviorArr[ $comment['BehaviorID'] ] . '</h4>';
				$currBehavior = $comment['BehaviorId'];
			}
			// Print out the name of the source student
			echo '<p> Source: ';
			// Print out the comment
			echo '<textarea> ' . $comment['Comment'] . '</textarea>';
		}	
	}
	// For each student get all comments 
	$query="SELECT c.Comment, c.SrcId FROM Comments c";
	$result=mysql_query($query);

	echo "<table border='1'>
	<tr>
		<th>Student Reviews</th>
		<th>Comments</th>
	</tr>";

	while($row = mysql_fetch_array($result))
  	{
		echo "<tr>";
		echo "<td>" . $row['Comment'] . "</td>";
		echo "<td>" . $row['SrcId'] . "</td>";
		echo "</tr>";
  	}
	echo "</table>";
	?>

     <div id="border">
       <form action="process.php" method="POST">
		<p>Based on evaluations, select student's grade</p>
		<select name="grade">
			<option value="a+">A+</option>
			<option value="a">A</option>
			<option value="a-">A-</option> 
			<option value="b+">B+</option> 
			<option value="b">B</option>
			<option value="b-">B-</option>  
			<option value="c+">C+</option>
			<option value="c">C</option>
			<option value="c-">C-</option>
			<option value="d+">D+</option>
			<option value="d">D</option>
			<option value="d-">D-</option>
		</select>
     </div>
 
     <div id="border1">
		<p>Add any comments for the student</p>
 		<textarea wrap="virutal" name="comments" rows="5" cols="50">Comment</textarea>
	</form>
     </div>
	<button type="button">Save Changes</button>
	<button type="button">Send to Student</button>
     
</div>

</body>
</html>
