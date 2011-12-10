<?php

include ("includes/login.php");

if ( $_SESSION[ 'userType' ] == 'faculty' ) {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=instruct/index.php">';	
	exit;
}
else if ( $_SESSION[ 'userType' ] == 'student' ) {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=student/index.php">';
	exit;
}
?>



