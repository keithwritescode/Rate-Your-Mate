<?php
include ( "../includes/config.php" );
include ( "../includes/opendb.php" );

// Get all Group IDs
$groupIDQueryString = ( " SELECT DISTINCT G.GrpID FROM Groups G WHERE
		G.PrjID = ".$_POST['prjID'].";" );
$groupIDQuery = mysql_query ( $groupIDQueryString );
$cnt = 0;
while ( $row = mysql_fetch_array( $groupIDQuery ) ) {
	$groupArr[$cnt++] = $row['GrpID'];
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
			VALUES ( ".$groupID.", '".$_POST['groupGoals']."', '".$_POST['additional'].
			"', ".$_POST['numBehaviors']. ");" );
	}
}
// Else just update the current table
else {
	foreach ( $groupArr as $groupID ) {
		mysql_query  ( "UPDATE ContractInfo SET Goals='".$_POST['groupGoals']."', Comments='".
			$_POST['additional']."', numBehaviors='".$_POST['numBehaviors']."' 
			WHERE GrpID=".$groupID.";" );
	}
}

// Delete any current behaviors
foreach ( $groupArr as $groupID ) {
	mysql_query ( "DELETE FROM Behaviors WHERE GrpID=".$groupID.";" );
	foreach ( $_POST['behavior'] as $behavior ) {
		mysql_query ( "INSERT INTO Behaviors (GrpID, Description)
			VALUES (".$groupID.", '".$behavior."');" );
	}
}
?>

<html>
        <head>
                <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
                <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
                <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
        </head>
        <body>
            <form id="instructor_setup" name="instructorsetup"
            action="index.php" method="post"  >
                        <input type="hidden" name="message" value=
				<?php if ($numResults==0) echo '"Contract created successfully!"';
					else echo '"Contract update was successful!"'; ?>/>
                        <input id="submit" type="submit" value="Submit" />

                </form>
        </body>
</html>
<script type="text/javascript">
        $(document).ready(function() {
                $(function() {
                        $( "#submit" ).click();
                });
        });
</script>

