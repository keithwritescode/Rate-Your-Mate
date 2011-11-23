<html>

<div id="head">

<head>

	<title>Rate Your Mate</title>


</head>

<h2>Instructor Evaluation</h2>

</div>

<div id="menu">
<?php include ("../includes/instruct_menu.php"); ?>
</div>


<div id="content">


<p align="left">


</br>

<font size="2" >Below are evaluations of group members each based on behaviors in their contract.</font>

</br>

</p>

<?php

include ("../includes/config.php");
include ("../includes/opendb.php");

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



</br>



<p>Based on evaluations, select student's grade</p>

<select>
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



</br>

<p>Add any comments for the student</p>

<form action="process.php" method="POST"> 

<textarea wrap="virutal" name="comments" rows="5" cols="50">Comment</textarea>


</form>

<button type="button">Save Changes</button>

<button type="button">Send to Student</button>



</div>

</body>
</html>
