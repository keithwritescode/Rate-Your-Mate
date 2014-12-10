<?php
	include ("../includes/config.php");
	include ("../includes/opendb.php");
	
	$query = mysql_query("SELECT PrjID FROM Project ORDER BY PrjID DESC LIMIT 1");
	list($prjID) = mysql_fetch_row($query);
	$prjID += 1;
		
	// Insert into project field
	mysql_query ("INSERT INTO Project (PrjName, CourseID,  NumGroups, ContractCreator, GradeSubmission, NumEvaluations, TotalPoints)
		VALUES ('".$_POST['projectID']. "', ".$_POST['crsID'].", ".$_POST['numGroups'].", " . $_POST['contractSubmit'] . ", " .  
			$_POST['gradeSubmit'] . ", " . $_POST['numEval'].", ".$_POST['pointAlloc'].")" );

	// Get each available date for evaluatees and evaluators
	$dateArr;
	$cnt = 0;
	foreach ( $_POST['evalt']['avail'] as $availDate ) {
		$dateArr['availt'][$cnt] = $availDate;
		$cnt++;
	}
	$cnt = 0;
	foreach ( $_POST['evalt']['due'] as $dueDate ) {
		$dateArr['duet'][$cnt] = $dueDate;
		$cnt++;
	}
	$cnt = 0;
	foreach ( $_POST['evale']['avail'] as $availDate ) {
		$dateArr['availe'][$cnt] = $availDate;
		$cnt++;
	}
	$cnt = 0;
	foreach ( $_POST['evale']['due'] as $dueDate ) {
		$dateArr['duee'][$cnt] = $dueDate;
		$cnt++;
	}

	for ( $i = 0; $i < $cnt; $i++ ) {
		$availt = $dateArr['availt'][$i];
		$duet = $dateArr['duet'][$i];
		$availe = $dateArr['availe'][$i];
		$duee = $dateArr['duee'][$i];
		$duetDate = date( 'Y-m-d', strtotime( $duet ) ); 
		$availeDate = date( 'Y-m-d', strtotime( $availe ) ); 
		$dueeDate = date( 'Y-m-d', strtotime( $duee ) ); 
		mysql_query ("INSERT INTO Evaluation (PrjId, EvalNum, StartDateEvaluator, EndDateEvaluator, StartDateEvaluatee, EndDateEvaluatee) ".
			        "VALUES (" . $prjID . ", " . ($i + 1) . ", '". $availtDate . "', '" .
					$duetDate . "', '" . $availeDate . "', '" . $dueeDate . "')" );

	}
	// Find the highest group inserted
	$maxGroup = mysql_query( "SELECT MAX(GrpID) FROM Groups" );
	$maxGroup = mysql_fetch_array( $maxGroup );
	$maxGroup = $maxGroup[0] + 1;
	// Insert into groups
	foreach ( $_POST['groups'] as $group ) {
		foreach ( $group as $student ) {
			mysql_query ( "INSERT INTO Groups (GrpID, PrjID, StudentID, ContractApprove) " .
				"VALUES (" . $maxGroup . ", " . $prjID . ", " . $student . ", 0)" );
		}
		$maxGroup++;
	}
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';	
exit;
?>

