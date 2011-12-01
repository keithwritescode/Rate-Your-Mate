<?php
$root = "http://".$_SERVER['SERVER_NAME'];


include ( "../includes/config.php" );
include ( "../includes/opendb.php" );
?>

<ul>
    <li> <a href="index.php"> Home </a> </li>
	<?php if ( !empty ( $_SESSION['crsID'] ) ) { 
	    echo '<li> <a href="project_setup.php"> Create new project </a> </li>';
    }  
	if ( !empty( $_SESSION['prjID'] ) ) {
		$creatorQuery = mysql_query( 'SELECT P.ContractCreator FROM Project P WHERE P.PrjID = ' . $_SESSION['prjID'] . ';' );
		$creator = mysql_fetch_array( $creatorQuery );
		$creator = $creator[0];
		if ( $creator[0] == 1 )
			echo '<li> <a href="create_contract.php"> Create/Edit the Contract </a> </li>';
		else echo '<li> <a href="view_contract.php"> View Team Contract </a> </li>';
		?>	
		<li> <a href="edit_project.php"> Edit current project </a> </li>
		<li> <a href="evaluatee_instructor.php" > Instructor Evaluation </a> </li>
	<?php } ?>
</ul>


