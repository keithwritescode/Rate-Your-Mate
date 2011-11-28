<?php include ("../includes/check_authorization.php");
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

?>
<html>
<head>
	<title>Rate Your Mate</title>
</head>

<body>
<div id="head">
	<h2>Instructor Evaluation</h2>
</div>

<div id="menu">
	<?php include ("../includes/instruct_menu.php"); ?>
</div>


<div id="content">
	<p>Below are evaluations of group members each based on behaviors in their contract.</p>

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

		<p>Add any comments for the student</p>
 		<textarea wrap="virutal" name="comments" rows="5" cols="50">Comment</textarea>
	</form>

	<button type="button">Save Changes</button>
	<button type="button">Send to Student</button>
</div>

</body>
</html>
