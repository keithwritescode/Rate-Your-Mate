<?php
$sessionID = session_id();

if( empty($sessionID) ) {
	session_start();
}

if ( !isset( $_SESSION['username'] ) ) {
   	$_SESSION['status'] = 'loggedout';
	header( "Location: index.php" );
}
?>
	
