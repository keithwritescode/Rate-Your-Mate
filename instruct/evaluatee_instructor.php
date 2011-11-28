<?php include ("../includes/check_authorization.php");
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />

		
	<title>Rate Your Mate</title>
</head>

<body>
<div id="header">
	<h1>Instructor Evaluation</h1>
</div>

<div id="menu">
	<?php include ("../includes/instruct_menu.php"); ?>
</div>


<div id="content">
	<h4><p>Below are evaluations of group members each based on behaviors in their contract.</p></h4>

	<?php
	$query="SELECT c.Comment, c.SrcId FROM Comments c";
	$result=mysql_query($query);

	echo "<table border='1'>
	<tr>
		<th>Student Reviews</th>
		<th>Comments</th>
	</tr>";

	while($row = mysql_fetch_array($result))
  	{
		echo "<tr>";
		echo "<td>" . $row['Comment'] . "</td>";
		echo "<td>" . $row['SrcId'] . "</td>";
		echo "</tr>";
  	}
	echo "</table>";
	?>

     <div id="border">
       <form action="process.php" method="POST">
		<p>Based on evaluations, select student's grade</p>
		<select name="grade">
			<option value="a+">A+</option>
			<option value="a">A</option>
			<option value="a-">A-</option> 
			<option value="b+">B+</option> 
			<option value="b">B</option>
			<option value="b-">B-</option>  
			<option value="c+">C+</option>
			<option value="c">C</option>
			<option value="c-">C-</option>
			<option value="d+">D+</option>
			<option value="d">D</option>
			<option value="d-">D-</option>
		</select>
     </div>
 
     <div id="border1">
		<p>Add any comments for the student</p>
 		<textarea wrap="virutal" name="comments" rows="5" cols="50">Comment</textarea>
	</form>
     </div>
	<button type="button">Save Changes</button>
	<button type="button">Send to Student</button>
     
</div>

</body>
</html>
