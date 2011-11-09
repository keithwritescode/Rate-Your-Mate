<html>


<div id="head">

<head>

	<title>Rate Your Mate</title>


</head>

<h2>Instructor Evaluation</h2>

</div>

<div id="menu">


<?php include ("../includes/menu.php"); ?>


</div>


<div id="content">


<p align="left">


<strong>Student Reviews<strong>

</br>

<font size="2" >Below are evaluations of group members each based on behaviors in their contract.</font>

</br>

</p>




<p align="left">
<strong>Behavior One</strong>



</p>

</br>

<form action="process.php" method="POST"> 

<textarea wrap="virutal" name="comments" rows="5" cols="50">Holder for student reviews</textarea>



</form>

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
