<?php
// Setup the session

include 'security_functions.php';
$username = casify();

// At log in start the session
$a = session_id();

if ( empty( $a ) ) {
	session_start();
}
else {
	session_destroy();
	session_start();
}

include ("includes/config.php");
include ("includes/opendb.php");

$_SESSION['username'] = $username;

$userQueryString = ("SELECT DISTINCT a.roleid as roleid, b.id as id, b.firstname as firstname, b.lastname as lastname 
	FROM mdl_role_assignments a, mdl_user b 
	WHERE b.username= '" . $_SESSION['username'] . "'");

$userQuery = mysql_query( $userQueryString );
	
$row = mysql_fetch_assoc($userQuery);
$_SESSION['userID'] = $row['id'];

if ($row['roleid'] == 1 || $row['roleid'] == 2) {
	$_SESSION['userType'] = 'admin';
}
else if ($row['roleid'] == 3 || $row['roleid'] == 4) {
	$_SESSION['userType'] = 'instructor'; 
}
else if ($row['roleid'] == 5) {
	$_SESSION['userType'] = 'student';
}
else if ($row['roleid'] == 6) {
	$_SESSION['userType'] = 'guest';	
}
else $_SESSION['userType'] = 'student';

?>
