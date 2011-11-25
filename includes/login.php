<?php
// Setup the session

include 'security_functions.php';
$username = casify();

// At log in start the session
$a = session_id();

if ( empty( $a ) ) {
	session_start();
}

$_SESSION['username'] = $username;
$_SESSION['userType'] = 'faculty';

?>


