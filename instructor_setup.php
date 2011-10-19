<?php include ("includes/check_authorization.php"); 
error_reporting(-1);
?>
<html>
<head>
	<title> Instructor Setup </title>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
 
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnAdd').click(function() {
                var num     = $('.clonedInput').length; 			// how many "duplicatable" input fields we currently have
                var newNum  = new Number(num + 1);      	// the numeric ID of the new input field being added
				$('#groupText').attr('value', newNum);
				
                // create the new element via clone(), and manipulate it's ID using newNum value
                var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
 
                // manipulate the name/id values of the input inside the new element
                newElem.children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
 
                // insert the new element after the last "duplicatable" input field
                $('#input' + num).after(newElem);
 
                // enable the "remove" button
                $('#btnDel').attr('disabled','');
 
                // business rule: you can only add 5 names
                if (newNum == 20 )
                    $('#btnAdd').attr('disabled','disabled');
            });
 
            $('#btnDel').click(function() {
                var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
                $('#input' + num).remove();     // remove the last element
				$('#groupText').attr('value', num-1);
 
                // enable the "add" button
                $('#btnAdd').attr('disabled','');
 
                // if only one element remains, disable the "remove" button
                if (num-1 == 1)
                    $('#btnDel').attr('disabled','disabled');
            });
			
			$('#groupText').change(function() {
			
				var num = $( '.clonedInput' ).length;
				var newNum = new Number( $('#groupText').attr('value') );
				
				$i = num+1;
				// If the new number is greater, add form elements
				while ($i < newNum ){					
					// create the new element via clone(), and manipulate it's ID using newNum value
					var newElem = $('#input' + num).clone().attr('id', 'input' + i);
	 
					// manipulate the name/id values of the input inside the new element
					newElem.children(':first').attr('id', 'name' + i).attr('name', 'name' + i);
	 
					// insert the new element after the last "duplicatable" input field
					$('#input' + num).after(newElem);
					
				}
				
			});
 
        
        });
    </script>
</head>
<body>
        <div id="header">
                <h1> Instructor Setup </h1>
        </div>

	<div id="menu">
		<?php include ("includes/menu.php"); ?>
	</div>

	<div id="content">
		<form id="instructor_setup" name="instructorsetup" 
		      action="instruct_submit.asp" method="post"  >
			Project I.D.: <input type="text" name="projectID" /> 	<br />
			Number of Groups: 
			<?php // Have a spinner that will increment, passes the max/min value in with it, so can resuse the JS for mulitple spinners ?>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td rowspan="2"><input  type="text" id="groupText" name="numGroups" value="1" style="width:50px;height:23px;font-weight:bold;" onchange="checkGroupValue();"/></td>
					<td><input type="button" id="btnAdd" value=" /\ " onclick="incrementSpinNum(20)" style="font-size:7px;margin:0;padding:0;width:20px;height:13px;" ></td>
				</tr>
				<tr>
					<td><input type="button" id="btnDel" value=" \/ " onclick="decrementSpinNum(1)" style="font-size:7px;margin:0;padding:0;width:20px;height:12px;" ></td>
				</tr>
			</table>

			<form id="createGroups">
				<div id="input1" class="clonedInput">
					Group: <input type="text" name="group1" id="group1" />
				</div>
				
				<div>

				</div>
			</form>
			
			<br />
			<p>Who creates the Contract? </p>
			<br />
			<input type="radio" name="creator" value="student" /> Student <br />
			<input type="radio" name="creator" value="faculty" /> Faculty <br />
			
			<p>Do you want to submit a grade for: </p>
			<input type="radio" name="gradeSubmit" value="1" /> Evaluatee Only	<br />
			<input type="radio" name="gradeSubmit" value="2" /> Evaluator Only	<br />
			<input type="radio" name="gradeSubmit" value="3" /> Both		<br />
			<input type="radio" name="gradeSubmit" value="4" /> None		<br />

			Number of Evaluations: <input type="text" name="numEval" />   <br />
			<input type="submit" value="Submit" />
		</form>
	</div>
</body>
 
</html>


