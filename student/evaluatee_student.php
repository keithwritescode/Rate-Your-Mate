<?php include ("../includes/check_authorization.php");
error_reporting(-1);

// Connect to the database
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
	<h1>Student Evaluation Page</h1>
</div>

<div id="menu">
	<?php include ("../includes/student_menu.php"); ?>
</div>


<div id="content">
	<p> Below is your group members evaluation of your work based on behaviors in their contract. </p>

	<?php
	$query="SELECT c.Comment, c.SrcId FROM Comments c";

<<<<<<< HEAD
<p align="left">


<strong>Student Reviews<strong>

</br>
</br>

<font size="2" >Below is your group members evaluation of your work based on behaviors in their contract.</font>

</br>

</p>

<div id="border4">
<?php
$query="SELECT c.Comment, c.SrcId FROM Comments c";

$result=mysql_query($query);

echo "<table border='none', cell spacing='10',

<tr>
<th><font color=#222222><font size=+1>Student Reviews</th></font></font>
<th><font color=#222222><font size=+1>Comments</th></font></font>
</tr>";

while($row = mysql_fetch_array($result))
  {

 echo "<tr>";

 echo "<td width=3%>" . "<font color=#223333>" . "<font size=+1>" . $row['Comment'] . "</td>" . "</font>" . "</font>";
 
 echo "<td width=3%>" . "<font color=#223333>" . "<font size=+1>" . $row['SrcId'] . "</td>". "</font>". "</font>";

 echo "</tr>";
 }

echo "</table>";
=======
	$result=mysql_query($query);
>>>>>>> 400e90254d2fe5d67cd64ce0af0d07e49fad8b81

	echo "<table border='1'>
		<tr>
		<th>Student Reviews</th>
		<th>Comments</th>
		</tr>";

	while($row = mysql_fetch_array($result)) {
	 echo "<tr>";
	 echo "<td>" . $row['Comment'] . "</td>";
	 echo "<td>" . $row['SrcId'] . "</td>";
	 echo "</tr>";
  	}

	echo "</table>";
?>

<<<<<<< HEAD
</div>

</br>





</form>

<button type="button">Accept</button>




=======
>>>>>>> 400e90254d2fe5d67cd64ce0af0d07e49fad8b81
</div>

</body>
</html>

