<?php

include ("includes/login.php");
echo '<input type="hidden" name="back" value="'.$_POST['message'].'">';

if ( $_SESSION[ 'userType' ] == 'faculty' ) {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=instruct/index.php">';	
	exit;
}
else if ( $_SESSION[ 'userType' ] == 'student' ) {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=student/index.php">';
	exit;
}
?>



