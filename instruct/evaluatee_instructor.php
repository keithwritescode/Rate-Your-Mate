<?php include ("../includes/check_authorization.php");
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");
$prjID = $_SESSION['prjID'];
$groupChangeFlag = 0;
if ( !empty( $_POST['groupID'] ) ) {
	if ( $_SESSION['groupID'] != $_POST['groupID'] ) {
		$_SESSION['groupID'] = $_POST['groupID'];
		// Unset the project
		unset( $_SESSION['studentID'] );
		$groupChangeFlag = 1;
	}
	else if ( !empty( $_POST['studentSelect'] )  && $_SESSION['studentID'] != $_POST['studentSelect'] ) {
		$_SESSION['studentID'] = $_POST['studentSelect'];
	}
}
if ( !empty( $_POST['evalType'] )) {
	$evalType= 'source';
	echo $_POST['evalType'];
}
else $evalType = 'target';
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
	<form id='groupSelectForm' name='form' action="evaluatee_instructor.php" method="post">
	<select name="groupID" onchange='this.form.submit()'>	
		<?php
		// Get all groups for this project
		$groupIDQuery = mysql_query ( " SELECT DISTINCT G.GrpID FROM Groups G WHERE
			G.PrjID = ".$prjID) or die( 'Error could not retrieve the group list' );
		$cnt = 1;
		// Select the group from the project to review, all groups have a default name
		while ( $groupID = mysql_fetch_array ( $groupIDQuery ) ) {
			$groupIDArr[$cnt] = $groupID['GrpID'];
			if ( empty( $_SESSION['groupID'] ) || empty( $_POST['groupID'] ) ) 
				$_SESSION['groupID'] = $groupID['GrpID'];
			if ( $_SESSION['groupID'] == $groupID['GrpID'] )
				$defaultString = 'selected="selected"';
			else $defaultString = '';
			echo '<option value="' . $groupID['GrpID'] . '" ' . $defaultString . '> Team ' . $cnt++ . '</option>';
		}
		?>	
	</select>

	<select name="studentSelect" onchange='this.form.submit()'>	
		<?php
		// Get the ID's of all group members
		$groupSdtIDQueryString = ( 'SELECT G.StudentID FROM Groups G WHERE G.GrpID = ' . $_SESSION['groupID'] ); 
		$groupSdtIDQuery = mysql_query( $groupSdtIDQueryString ) or die( 'Error could not retreive groups' );;
		
		$cnt = 0;	
		// Select the student from the group to be reviewed
		while ( $studentID = mysql_fetch_array( $groupSdtIDQuery ) ) {
			
			foreach ( $_SESSION['roster'] as $student ) {
				if ( empty( $_SESSION['studentID'] ) || $groupChangeFlag == 1 || empty( $_POST['groupID'] ) )
					$_SESSION['studentID'] = $student['id'];
				if ( $_SESSION['studentID'] == $student['id'] ) {
					$defaultString = 'selected="selected"';
					$studentName = $student['name'];
				}
				else $defaultString = '';
				if ( $student['id'] == $studentID['StudentID'] ) {
					$groupArr[$student['id']] = $student['name'];
					echo '<option value = ' . $student['id'] . ' ' . $defaultString . '> ' . $student['name'] . '</option>';
				}
			}
		}
		?> 
	</select>
	<input type="checkbox" id="evalCheck" name="evalType" value="howdy" onchange='this.form.submit()' 
		<?php if( $evalType == 'source' ) echo 'checked'; ?>/> Evaluations by this student 
	</form>
		
	<h4>Below is the feedback for <?php echo $studentName; ?> from their teammates </h4>

	<?php
	// Get all the behaviors the group has
	$behaviorQueryString = ( 'SELECT B.BehaviorID, B.Description
		FROM Behaviors B
		WHERE B.GrpID = ' . $_SESSION['groupID'] . ';');

	$behaviorQuery = mysql_query( $behaviorQueryString );
	if ( $behaviorQuery ) {
		$behaviorCnt = mysql_num_rows( $behaviorQuery );
	}
	else $behaviorCnt =
	// Put into an array
	$cnt = 0;

	// Only try to display comments if the contract exists
	if ( $behaviorCnt != 0 ) {
	while ( $behavior = mysql_fetch_array( $behaviorQuery ) ) {
		$behaviorArr[ $behavior['BehaviorID'] ] = $behavior['Description'];
	}
	
	// Get all comments related to this student for this project	
	$commentQueryString = 'SELECT C.SrcId, C.Comment, C.BehaviorId FROM Comments C 
		WHERE C.PrjID = ' . $_SESSION['prjID'] . ' AND C.TargetId = ' . $_SESSION['studentID'] . ' ORDER BY C.BehaviorId;';
	$commentQuery = mysql_query( $commentQueryString ) or die ( 'Could not find student comments' );

	// Print out the behavior
	$cnt = 0;
	while ( $comment = mysql_fetch_array( $commentQuery ) ) {
		// If this is the first for this behavior, create a header
		if ( empty( $currBehavior ) || $currBehavior != $comment['BehaviorId'] ) {
			echo '<h4> ' . $behaviorArr[ $comment['BehaviorId'] ] . '</h4>';
			$currBehavior = $comment['BehaviorId'];
		}
		// Print out the student who wrote the review
		echo '<p> Source: ' . $groupArr[$comment['SrcId'] ]. '</p>';
		// Print out the comment
		echo '<textarea> ' . trim( $comment['Comment'] ) . '</textarea>';
	}
	}
	else { ?>
		<p> No contract was found for this group! </p>
	<?php } ?>
 
</div>

</body>
</html>
