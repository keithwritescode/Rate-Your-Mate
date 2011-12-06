<?php
include ( "../includes/config.php" );
include ( "../includes/opendb.php" );


$groupID = $_POST['groupID'];
print_r( $_POST );
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

