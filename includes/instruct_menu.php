<?php
$root = "http://".$_SERVER['SERVER_NAME'];
?>

<ul>
        <li> <a href="index.php"> Home </a> </li>
	<?php if ( !empty ( $_SESSION['crsID'] ) ) { ?>
	        <li> <a href="project_setup.php"> Instructor Setup </a> </li>
        <?php }  if ( !empty( $_SESSION['prjID'] ) ) { ?>
		<li> <a href="create_contract.php"> Create a Contract </a> </li>
        	<li> <a href="evaluatee_instructor.php" > Instructor Evaluation </a> </li>
	<?php } ?>
</ul>


