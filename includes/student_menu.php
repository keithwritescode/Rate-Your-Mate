<?php

$root = "http://".$_SERVER['SERVER_NAME'];

// Figure out if the current project allows for student contract editing
if ( $_SESSION['prjID'] != -1 ) {
	$contractCreatorQueryString = 'SELECT P.ContractCreator FROM Project P WHERE P.PrjID = ' . $_SESSION['prjID'] . ';'; 
	$contractCreatorQuery = mysql_query ( $contractCreatorQueryString ) or die ('ERROR: instruct_menu.php could not find contract' );
	
	if ( $contractCreatorQuery ) {
		$contractCreator = mysql_fetch_array ( $contractCreatorQuery );
		$contractCreator = $contractCreator[0];
	}
}
?>

<ul>
        <li> <a href="index.php"> Home </a>  </li>
	<?php if ( $_SESSION['prjID'] != -1 ) {
	
		if ( $contractCreator == 0 )
			echo '<li> <a href="../student/create_contract.php"> Create Contract </a>  </li>';
		else
			echo '<li> <a href="../student/view_contract.php"> View Contract </a>  </li>';
	?>
        <li> <a href="../student/student_input.php"> Evaluate Team </a>                </li>
        <li> <a href="../student/evaluatee_student.php"> Review Evaluations</a>        </li>
	<?php } ?>
</ul>

