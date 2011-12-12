<?php
	session_start();
	//$_SESSION['username'] = 'admin';
	//$_SESSION['groupID'] = "1";
	$username = "jadennett";
	$password = "hensvolk";
	$hostname = "turing"; 
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
	
	sessionRoll();
	
function sessionRoll()
{
	$username = "jadennett";
	$password = "hensvolk";
	$hostname = "turing"; 
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	$selected = mysql_select_db("wp1",$dbhandle) or die("Could not select examples");
	$result = mysql_query("SELECT DISTINCT a.roleid as roleid, b.id as id, b.firstname as firstname, b.lastname as lastname 
							FROM mdl_role_assignments a, mdl_user b 
							WHERE b.username='{$_SESSION['username']}'");
	
	$row = mysql_fetch_assoc($result);
	if ($row['roleid'] = 3)
	{
		$_SESSION['userType'] = 'instructor';
	}
	else if ($row['roleid'] = 1)
	{
		$_SESSION['userType'] = 'admin';
	}
	else if ($row['roleid'] = 2)
	{
		$_SESSION['userType'] = 'admin';
	}
	else if ($row['roleid'] = 4)
	{
		$_SESSION['userType'] = 'instructor';
	}
	else if ($row['roleid'] = 5)
	{
		$_SESSION['userType'] = 'student';
	}
	else if ($row['roleid'] = 6)
	{
		$_SESSION['userType'] = 'guest';	
	}
}
	//print_r ($row);
	
	if ($_SESSION['userType'] <> 5 && $_SESSION['userType'] <> 6)
	{
		$teacher = 1;
	}
	
	