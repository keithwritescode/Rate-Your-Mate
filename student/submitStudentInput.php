<?php
$sessionID = session_id();	
if( empty($sessionID) ) {
        echo 'weeee';
}

include ("../includes/config.php");
include ("../includes/opendb.php");

// Get the behavior ID list
$behaviorQuery =  mysql_query( "SELECT B.BehaviorID
			FROM Behaviors B
			WHERE B.PrjID = ".$_POST['prjID']. " 
			AND B.GrpID = ( SELECT G.GrpID FROM
				Groups G WHERE G.StudentID =".$_POST['userID'].");" );
echo $_SESSION['userID'];
echo ( "SELECT B.BehaviorID
		FROM Behaviors B
		WHERE B.PrjID = ".$_POST['prjID']. " 
		AND B.GrpID = ( SELECT G.GrpID FROM
		Groups G WHERE G.StudentID =".$_POST['userID'].");" );
$cnt = 0;
	
while ( $behaviorID = mysql_fetch_row($behaviorQuery) ) {
	$behaviorIDs[$cnt] = $behaviorID[0];
	$cnt++;
}
	
foreach ( $_POST['student'] as $student_id=>$student ){			
	$cnt = 0;
	foreach ( $student as $comment_id=>$comment ) {
		// Current behavior
		mysql_query ("INSERT INTO Comments (BehaviorId, SrcId, TargetId, Comment)
			VALUES (".$behaviorIDs[$cnt].", ".$_POST['userID'] .", ".$student_id .", '".$comment ."');" );
		$cnt++;
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
            action="../index.php" method="post"  >
                        <input type="hidden" name="message" value="Peer Review Form successfully submitted!" />
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
