<?php
include ( "../includes/config.php" );
include ( "../includes/opendb.php" );


$groupID = $_POST['groupID'];

// Get all behaviors for the group
$groupQueryString = ( 'SELECT B.* FROM Behaviors B WHERE
                              B.GrpID = ' . $groupID . ';');
echo $groupQueryString;
$groupQuery = mysql_query($groupQueryString);

// If $numResults is 0, submit everything
mysql_query ( 'DELETE FROM ContractInfo WHERE GrpID =' . $groupID . ';' );
if ( $numResults == 0 ) {
	// Do for each group
	mysql_query ( 'INSERT INTO ContractInfo ( GrpID, Goals, Comments, numBehaviors)
		VALUES ( ' . $groupID . ', "' . trim( $_POST['groupGoals'] ) . '", "' . trim( $_POST['additional'] ) .
		'", ' . $_POST['numBehaviors'] . ');' );
}

mysql_query ( 'DELETE FROM Behaviors WHERE GrpID =' . $groupID . ';' );
foreach ( $_POST['behavior'] as $behavior ) {
	mysql_query ( "INSERT INTO Behaviors (GrpID, Description)
		VALUES (" . $groupID . ", '" . trim( $behavior ) . "');" );
}
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
exit;
?>


