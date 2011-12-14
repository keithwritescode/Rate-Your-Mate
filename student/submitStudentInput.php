<?php include ("../includes/check_authorization.php");


include ("../includes/config.php");
include ("../includes/opendb.php");
$scores = explode(", ", $_POST['kittens']);

$cnt = 0;
foreach ( $_SESSION['group'] as $id => $name ) {
	if ( $id != $_SESSION['userID'] ) {
		mysql_query ('INSERT INTO Scores ( PrjID, SrcID, TargetID, Score )
			VALUES ( ' . $_SESSION['prjID'] . ', ' . $_SESSION['userID'] . ', ' . $id . ', ' . $scores[$cnt++] . ');' );
	}
}

// Get the behavior ID list
$behaviorQueryString = ( 'SELECT B.BehaviorID
			FROM Behaviors B
			WHERE B.GrpID = ' . $_SESSION['groupID'] . ';');

$behaviorQuery = mysql_query( $behaviorQueryString );

$cnt = 0;
	
while ( $behaviorID = mysql_fetch_row( $behaviorQuery ) ) {
	$behaviorIDs[$cnt] = $behaviorID[0];
	$cnt++;
}
	
foreach ( $_POST['student'] as $student_id=>$student ){			
	$cnt = 0;
	foreach ( $student as $comment_id=>$comment ) {
		// Current behavior
		mysql_query( "INSERT INTO Comments (BehaviorId, PrjID, SrcId, TargetId, Comment)
			VALUES (".$behaviorIDs[$cnt].", ". $_SESSION['prjID'] . ", " . 
			$_SESSION['userID'] . ", " . $student_id . ", '".$comment ."');" );
		$cnt++;
	}
}
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';	
exit;
?>

