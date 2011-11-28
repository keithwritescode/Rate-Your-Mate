<?php include ("../includes/check_authorization.php");
error_reporting(-1);

print_r($_POST);
if ( !empty( $_POST['classSelect'] ) )
	$_SESSION['crsID'] = $_POST['classSelect'];
if ( !empty( $_POST['projectSelect'] ) ) 
	$_SESSION['prjID'] = $_POST['projectSelect'];
?>
<html>
<head>
    <title> Instructor Home </title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
    <script src="../js/instruct_home.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
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
			if ( empty ( $_SESSION['crsID'] ) ) { ?>
				<p> Choose a course to select a Rate-Your-Mate project </p>
				<select id='classSelect' name='classSelect'>
					<option value="1"> Course 1 </option>
					<option value="2"> Course 2 </option>
				</select>
			<?php }
			else if ( empty ( $_SESSION['prjID'] ) ) { ?>
				<p> Class <?php $_SESSION['crsID'] ?> selected </p>
				<p> Choose a project or create one to begin </p>
				<select id='projectSelect' name='projectSelect'>
					<option> Project 1 </option>
					<option> Project 2 </option>
				</select>
			<?php }
			else { ?>
				<p> Class <?php $_SESSION['crsID'] ?>, Project <?php $_SESSION['prjID'] ?> selected </p>
                        	<p> Change classes </p>
                        	<select id='classSelect' name='classSelect'>
                                	<option value="1"> Class 1 </option>
                        	        <option value="2"> Class 2 </option>
                	        </select>
		
				<p> Change projects </p>
        	                <select id='projectSelect' name='projectSelect'>
                	                <option> Project 1 </option>
                        	        <option> Project 2 </option>
                        	</select>

			<?php } ?>
			<input id='submit' type="submit" style="visibility:hidden" />
			</form>
		</div>
	</div>
</body>
</html>
