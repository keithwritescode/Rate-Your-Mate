<?php include ("../includes/check_authorization.php"); 
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

$studentID = 4;

?>
<html>
	<head>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>

		<title>Rate Your Mate</title>

	</head>

	<body>
		<div id="head">
			<h2>Create Contract</h2>
		</div>	

		<div id="menu">
		  
			<?php include ("../includes/menu.php"); ?>
		</div>		

		<div id="content">

			<p>Project I.D.</p>
			
			<select>
				<?php
				$query = mysql_query( " SELECT P.PrjName, P.PrjID FROM Project P, Groups G " .
						" WHERE G.StudentID = " . $studentID . " AND " .
						"P.PrjID = G.PrjID;" ); 
			 	$i = 0;
				while ( $row = mysql_fetch_array($query) ) { 
					echo '<option value = "' . $row['PrjID'] . '">' . $row['PrjName'] . 
						'</option>';	
         				$prjID[$i++] = $row['PrjID'];
				}
				?>			  
			</select>

			<br/>

			<p>Group Goals<p/>
			<?php
			// Fetch all Contract to do with this project and student
			$contractQuery = mysql_query ( " SELECT C.* FROM Contracts C, Groups G WHERE
						C.GrpID = G.GrpID AND G.StudentID = ".$studentID );
			// Get all behaviors for the group
			$groupQuery = mysql_query ( " SELECT B.* FROM Behaviors B, Contracts C WHERE
							B.BehaviorID = C.BehaviorID AND 
							C.ContractID = " . $prjID[0] );
			$numResults = mysql_num_rows($groupQuery);
			?>
			<textarea wrap="virutal" name="groupGoals" rows="5" cols="50"></textarea>

			<p> How many behaviors will your contract contain? </p>
			<input type="number" id="groupText" name="numGroups" value="<?php
				if ($numResults > 0)
					echo $numResults;
				else
					echo 1; ?>" size="4" min="1" max="6"/>

			<div id='behaviors' class='behaviors'>
				<?php
				// Write in all behaviors
				$numResults = mysql_num_rows($groupQuery);
				$i = 0;
				if ( $numResults > 0 ) {
					while ( $row = mysql_feth_array($groupQuery) ) {
						echo '<h4> Behavior ' . $i++ . ' <h4>';
						echo '<textarea class="behavioText" rows="2" cols="20">'.
							$row['Description'] . '</textarea>';								}
				}
				// If there arent any previous fields provide one empty one
				else {
					echo '<h4> Behavior 1 </h4>';
					echo '<textarea class="behaviorText" rows="2" cols="20"></textarea>';
				}

				?>
			</div>

			<br/>

			<p>Additional Comments<p/>
			<textarea wrap="virutal" name="additional" rows="5" cols="50"></textarea>
			<br/>

			<input type="submit" value='Submit Contract'/>
			<input type="submit" value='Accept'/>
			<input type="submit" value='Cancel'/>
		</div>
	</body>


<script type="text/javascript">
$(document).ready(function () {
	$('#groupText').keyup(function() {
		var num = new Number ( $( '#groupText' ).attr('value') );
		var max = new Number ( $( '#groupText' ).attr( 'max' ) );
		
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
				$('#behaviors h4:last').remove();
				$('.behaviorText:last').remove();	
			}
		}
	});
});
</script>


</html>
