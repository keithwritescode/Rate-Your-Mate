<?php
	include ("../includes/config.php");
	include ("../includes/opendb.php");
	
	$query = mysql_query("SELECT COUNT(*) FROM Project");
	list($prjID) = mysql_fetch_row($query);
	$prjID += 1;
	// Insert into project field
	mysql_query ("INSERT INTO Project (PrjName, NumGroups, ContractCreator, GradeSubmission, NumEvaluations, TotalPoints)
		VALUES ('".$_POST['projectID']. "', ".$_POST['numGroups'].", " . $_POST['contractSubmit'] . ", " .  
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
		echo ("INSERT INTO Evaluation (PrjId, EvalNum, StartDateEvaluator, EndDateEvaluator, StartDateEvaluatee, EndDateEvaluatee) ".
			        "VALUES (" . $prjID . ", " . ($i + 1) . ", ".$dateArr['availt'][$i]. "), " .
					$dateArr['duet'][$i] . ", " . $dateArr['availe'][$i] . ", " . $dateArr['duee'][$i] . ")" );
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
	
	
//print_r($dateArr);
print_r($_POST);
?>
