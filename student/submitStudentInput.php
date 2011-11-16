<?php
	include ("../includes/config.php");
	include ("../includes/opendb.php");

	// Get the behavior ID list
	$behaviorQuery =  mysql_query( "SELECT B.BehaviorID
				FROM Behaviors B
				WHERE B.PrjID = ".$_POST['prjID']. " 
				AND B.GrpID = ( SELECT G.GrpID FROM
					Groups G WHERE G.StudentID =".$_SESSION['userID'].");" );
	echo $_SESSION['userID'];
	echo ( "SELECT B.BehaviorID
				FROM Behaviors B
				WHERE B.PrjID = ".$_POST['prjID']. " 
				AND B.GrpID = ( SELECT G.GrpID FROM
					Groups G WHERE G.StudentID =".$_SESSION['userID'].");" );
	$cnt = 0;
	
	/*
	while ( $behaviorID = mysql_fetch_row($behaviorQuery) ) {
		$behaviorIDs[$cnt] = $behaviorID;
	}
	*/
	print_r($behaviorIDs);
	foreach ( $_POST['student'] as $student_id=>$student ){			
		foreach ( $student as $comment_id=>$comment ) {
			// Current behavior

			echo ("INSERT INTO Comments (BehaviorId, SrcId, TargetId, Comment)
					VALUES (".$behaviorID.", ".$_POST['studentID'] .", ".$student_id .", '".$comment ."');" );
		}
	}
	
	
	print_r($_POST);
?>
<form id="instructor_setup" name="instructorsetup" 
    action="../index.php" method="post"  >
	<input type="hidden" name="message" value="Peer Review form submitted!" />
	<input id="submit" type="submit" value="Submit" />
</form>

<script type="text/javascript">
/*
	$(document).ready(function() {
		$(function() {
			$( "#submit" ).click();
		});
	});
*/
</script>