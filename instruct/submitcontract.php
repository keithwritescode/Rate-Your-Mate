<?php include ("../includes/check_authorization.php");

include ( "../includes/config.php" );
include ( "../includes/opendb.php" );

// Get all Group IDs
if ( !empty( $_POST['prjID'] ) {
	$groupIDQueryString = ( " SELECT DISTINCT G.GrpID FROM Groups G WHERE
			G.PrjID = ".$_POST['prjID'].";" );
	$groupIDQuery = mysql_query ( $groupIDQueryString );
	
	$cnt = 0;
	while ( $row = mysql_fetch_array( $groupIDQuery ) ) {
        	$groupArr[$cnt++] = $row['GrpID'];
	}
}
else {
	$_SESSION['message'] = 'No Project ID provided, project not submitted';
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
	exit;
}

// Get all behaviors for the group
$groupQueryString = ( " SELECT B.* FROM Behaviors B WHERE
                              B.GrpID = ".$groupArr[0].";");
$groupQuery = mysql_query($groupQueryString);
$numResults = mysql_num_rows( $groupQuery );

// If $numResults is 0, submit everything
if ( $numResults == 0 ) {
	// Do for each group
	foreach ( $groupArr as $groupID ) {
		mysql_query ( "INSERT INTO ContractInfo ( GrpID, Goals, Comments, numBehaviors)
			VALUES ( ".$groupID.", '".trim($_POST['groupGoals'])."', '".trim($_POST['additional']).
			"', ".$_POST['numBehaviors']. ");" );
	}
}
// Else just update the current table
else {
	foreach ( $groupArr as $groupID ) {
		mysql_query  ( "UPDATE ContractInfo SET Goals='".trim($_POST['groupGoals'])."', Comments='".
			trim($_POST['additional'])."', numBehaviors='".$_POST['numBehaviors']."' 
			WHERE GrpID=".$groupID.";" );
	}
}

// Delete any current behaviors
foreach ( $groupArr as $groupID ) {
	mysql_query ( "DELETE FROM Behaviors WHERE GrpID=".$groupID.";" );
	foreach ( $_POST['behavior'] as $behavior ) {
		mysql_query ( "INSERT INTO Behaviors (GrpID, Description)
			VALUES (".$groupID.", '".trim($behavior)."');" );
	}
}
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
exit;
?>


