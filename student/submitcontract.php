<?php
include ( "../includes/config.php" );
include ( "../includes/opendb.php" );

print_r( $_POST );

// Get the Group ID
$groupIDQuery = mysql_query ( " SELECT G.GrpID FROM Groups G WHERE
				G.PrjID = ".$_POST['prjID']." AND
				G.StudentID = ".$_POST['studentID'].";" );
$groupID = mysql_fetch_array ( $groupIDQuery );
$groupID = $groupID['GrpID'];
// Get all behaviors for the group
$groupQuery = mysql_query ( " SELECT B.* FROM Behaviors B, Contracts C WHERE
                              B.BehaviorID = C.BehaviorID AND
                              C.ContractID = " . $_POST['prjID'] );
$numResults = mysql_num_rows( $groupQuery );

print_r($groupID);
// If $numResults is 0, submit everything
if ( $numResults == 0 ) {
	mysql_query ( "INSERT INTO ContractInfo (GrpID, Goals, Comments, numBehaviors)
		VALUES ( ".$groupID.", '".$_POST['groupGoals']."', '".$_POST['additional'].
		"', ".$_POST['numBehaviors']. ");" );
}
// Else just update the current table
else {
	echo ( "UPDATE ContractInfo SET Goals='".$_POST['groupGoals']."', Comments='".
			$_POST['additional']."', numBehaviors='".$_POST['numBehaviors']."' 
			WHERE GrpID=".$groupID.";" );
}

// Delete any current behaviors
mysql_query ( "DELETE FROM Behaviors WHERE GrpID=".$groupID.";" );
foreach ( $_POST['behavior'] as $behavior ) {
	mysql_query ( "INSERT INTO Behaviors (GrpID, Description)
		VALUES (".$groupID.", '".$behavior."');" );
}
?>
