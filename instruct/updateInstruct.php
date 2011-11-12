<?php
	include ("../includes/config.php");
	include ("../includes/opendb.php");
	
	$query = mysql_query("SELECT PrjID FROM Project ORDER BY PrjID DESC LIMIT 1");
	list($prjID) = mysql_fetch_row($query);
	$prjID += 1;
	// Insert into project field
	mysql_query ("INSERT INTO Project (PrjName, NumGroups, ContractCreator, GradeSubmission, NumEvaluations, TotalPoints)
		VALUES ('".$_POST['projectID']. "', ".$_POST['numGroups'].", " . $_POST['contractSubmit'] . ", " .  
		$duetDate = date( 'Y-m-d', strtotime( $duet ) ); 
		$availeDate = date( 'Y-m-d', strtotime( $availe ) ); 
		$dueeDate = date( 'Y-m-d', strtotime( $duee ) ); 
		mysql_query ("INSERT INTO Evaluation (PrjId, EvalNum, StartDateEvaluator, EndDateEvaluator, StartDateEvaluatee, EndDateEvaluatee) ".
			        "VALUES (" . $prjID . ", " . ($i + 1) . ", '". $availtDate . "', '" .
					$duetDate . "', '" . $availeDate . "', '" . $dueeDate . "')" );

	}
	$teamNum = 1;
	// Insert into groups
	foreach ( $_POST['groups'] as $group ) {
		foreach ( $group as $student ) {
			mysql_query ( "INSERT INTO Groups (GrpID, PrjID, StudentID, ContractApprove) " .
				"VALUES (" . $teamNum . ", " . $prjID . ", " . $student . ", 0)" );
		}
		$teamNum++;
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
			<input type="hidden" name="message" value="Project Creation Form successfully submitted!" />
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


</script>
