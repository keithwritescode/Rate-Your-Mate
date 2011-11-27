<?php
$root = "http://".$_SERVER['SERVER_NAME'];
?>

<ul>
        <li> <a href="index.php"> Home </a> </li>
	<?php if ( !empty ( $_SESSION['crsID'] ) ) { ?>
	        <li> <a href="project_setup.php"> Create new project </a> </li>
        <?php }  if ( !empty( $_SESSION['prjID'] ) ) { ?>
		<li> <a href="create_contract.php"> Create/Edit the Contract </a> </li>
		<li> <a href="edit_project.php"> Edit current project </a> </li>
        	<li> <a href="evaluatee_instructor.php" > Instructor Evaluation </a> </li>
	<?php } ?>
</ul>


