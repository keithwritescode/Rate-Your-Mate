<?php include ("../includes/check_authorization.php");
error_reporting(-1);

if ( !empty( $_POST['classSelect'] ) )
	$_SESSION['crsID'] = $_POST['classSelect'];
if ( !empty( $_POST['projectSelect'] ) ) 
	$_SESSION['prjID'] = $_POST['projectSelect'];

// For now hardwire in the roster

$_SESSION['roster'] = array(
    array("screenname" => "kmreynolds1", "name" => "Kris Reynolds", "id" => 1),
    array("screenname" => "bpbielicki", "name" => "Ben Bielicki", "id" => 2),
    array("screenname" => "mdecota", "name" => "Michael Decota", "id" => 3),
    array("screenname" => "jdennett", "name" => "Jason Dennett", "id" => 4),
    array("screenname" => "tferm", "name" => "Tyler Ferm", "id" => 5),
    array("screenname" => "khallock", "name" => "Keith Hallock", "id" => 6),
    array("screenname" => "rameden", "name" => "Ryley Ameden", "id" => 7),
    array("screenname" => "cbecker", "name" => "Chris Becker", "id" => 8),
    array("screenname" => "jcormier", "name" => "Joe Cormier", "id" => 9),
    array("screenname" => "cstoner", "name" => "Cara Stoner", "id" => 10)
);

// Get the roster for the class selected and store it into roster of session

?>
<html>
<head>
    <title> Instructor Home </title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
    <link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
	<div id="message">
		<?php
		if ( !empty( $_POST['message'] ) )
			echo '<p>' . $_POST['message'] . '</p>';
		?>
	<div id="header">
		<h1> Instructor Home </h1>
	</div>
	<div id="menu">
		<?php include ("../includes/instruct_menu.php"); ?>
	</div>

	<div id="content">
		
		<div id="projectSelect">
			<form id='projectForm' name="instructorHome"
				action="index.php" method="post" >
			<?php
			if ( empty ( $_SESSION['crsID'] ) ) { 
				echo '<p> Choose a course to select a Rate-Your-Mate project </p>';
			} 
			else {
				echo '<p> Class ' . $_SESSION['crsID'] . ' is selected, change course? </p>';
			} ?>
			<select id='classSelect' name='classSelect' onchange='this.form.submit()'>
				<option value="1"> Course 1 </option>
				<option value="2"> Course 2 </option>
			</select>
			
			<?php 
			if ( empty ( $_SESSION['prjID'] ) ) { 
				echo '<p> No project selected, select a project or create a new one to begin </p>';
			}
			else {
				echo '<p> Project ' . $_SESSION['prjID'] . ' selected, change project? </p>';
			} ?>
			<select id='projectSelect' name='projectSelect' 
				<?php if (empty($_SESSION['crsID'])) echo 'disabled="disabled"'?> onchange='this.form.submit()'>
				<option value="72"> Project 1 </option>
				<option value="73"> Project 2 </option>
			</select>
				
			</form>
                        <input id='submit' type="submit" style="visibility:hidden" />

		</div>
	</div>

</body>
</html>
