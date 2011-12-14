<?php
	//session_start();
	//$_SESSION['username'] = 'admin';
	//$_SESSION['groupID'] = "1";
	$username = "jadennett";
	$password = "hensvolk";
	$hostname = "turing"; 
	$groupSize = 0;
	//connection to the database
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	$selected = mysql_select_db("wp1",$dbhandle) or die("Could not select examples");
	
	$result = mysql_query("SELECT a.GrpID as groupID
							FROM Groups a 
							WHERE a.GrpID = '{$_SESSION['groupID']}'");
	while ($row = mysql_fetch_assoc($result))
	{
		$groupSize++;
	}
	$groupSize -= 1;
	
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	$selected = mysql_select_db("wp1",$dbhandle) or die("Could not select examples");
	$result = mysql_query("SELECT b.GrpID as groupID, b.PrjID as PrjIDb, a.TotalPoints as totalPoints, a.PrjID as PrjIDa
							FROM Project a, Groups b
							WHERE b.GrpID = '{$_SESSION['groupID']}' AND a.PrjID = b.PrjID");

	$row = mysql_fetch_assoc($result);	
	$maxPoints = $row['totalPoints'];
	
	if ($_SESSION['userType'] == 'student' || $_SESSION['userType'] == 'guest')
	{
		$teacher = 0;
	}
	else 
	{
		$teacher = 1;
	}
	
	?>
	
	
	
	