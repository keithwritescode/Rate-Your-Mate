
<html>


<div id="head">

<head>

 <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
 <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>

<title>Rate Your Mate</title>

</head>


</div>

<h2>Create Contract</h2>
	

<div id="menu">

<?php include ("../includes/menu.php"); ?>

</div>

<body>

<div id="content">

<p>Project I.D.</p>

<select>
  <option value="prj">Project ID</option>
  
</select>

<br/>

<p>Group Goals<p/>

<textarea wrap="virutal" name="comments" rows="5" cols="50"></textarea>


<p> How many behaviors will your contract contain? </p>

<input type="number" id="groupText" name="numGroups" value="1" size="4" min="1" max="6"/>

<div id='behaviors' class='behaviors'>
<h4> Behavior 1 </h4>
<textarea class="behaviorText" rows="2" cols="20"></textarea>
</div>


<br/>

<p>Additional Comments<p/>

<textarea wrap="virutal" name="additional" rows="5" cols="50"></textarea>

<br/>


<input type="submit" value='Submit Contract'/>

<input type="submit" value='Accept'/>

<input type="submit" value='Cancel'/>






</body>


<script type="text/javascript">
$(document).ready(function () {
	$('#groupText').keyup(function() {
		var num = $( '#groupText' ).attr('value');
		var max = $( '#groupText' ).attr( 'max' );
		
		if ( num > max ){ 
			$( '#groupText' ).attr( 'value', max );	
		}
		$( '#groupText' ).click();
		
	});
	$('#groupText').click(function() {
		var num = $( '.behaviorText' ).length;

		var newNum = Number( $('#groupText').attr('value') );
		newNum = Math.round(newNum);

		// If adding to the form
		if (num < newNum ) {
			for ( var i = num + 1; i <= newNum; i++ ) {
				var insertHtml =
                          		'<h4> Behavior ' + i +  '</h4>' + 
                          		'<textarea id="b' + i +
					'" class="behaviorText" rows="2" cols="20"></textarea>';
				$('.behaviors').append(insertHtml);

			}
		}
		if ( num > newNum) {
			for ( var i = num; i > newNum; i-- ) {
				$('.behaviorText:last').remove();	
			}
		}
	});
});
</script>


</html>
