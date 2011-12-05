<?php include ("../includes/check_authorization.php"); 
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

$studentID = 4;
$prjID = 72;
?>
<html>
	<head>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
		
		<title>Rate Your Mate</title>

	</head>

	<body>
		<div id="header">
			<h2>Create Contract</h2>
		</div>	

		<div id="menu">
			<?php include ("../includes/student_menu.php"); ?>
		</div>		

		<div id="content">
			<?php
			// Get the Group ID
			$groupIDQuery = mysql_query ( " SELECT G.GrpID FROM Groups G WHERE
                                G.PrjID = ".$prjID." AND
                                G.StudentID = ".$studentID.";" );
			$groupID = mysql_fetch_array ( $groupIDQuery );
			$groupID = $groupID['GrpID'];
			// Get all behaviors for the group
			$groupQuery = mysql_query ( " SELECT * FROM Behaviors WHERE
                              GrpID = " . $groupID . ";" );
			$numResults = mysql_num_rows( $groupQuery );
	
			?>
			<form id="contractsetup" name="contractsetup" action="submitcontract.php" method="post">
				<p> Group Goals </p>
				<textarea wrap="virutal" name="groupGoals" rows="5" cols="50"></textarea>
				
				<p> How many behaviors will your contract contain? </p>
				<input type="number" id="groupText" name="numBehaviors" value="<?php
					if ($numResults > 0)
						echo $numResults;
					else
						echo 1; ?>" 
					size="4" min="1" max="6"/>
	
				<div id='behaviors' class='behaviors'>
					<?php
					// Write in all behaviors
					$numResults = mysql_num_rows($groupQuery);
					$i = $numResults;
					if ( $numResults > 0 ) {
						while ( $row = mysql_fetch_array($groupQuery) ) {
							echo '<h4> Behavior ' . $i . ' <h4>';
							echo '<textarea class="behaviorText" name="behavior['.$i++.']" rows="2" cols="20">'.
								$row['Description'] . '</textarea>';								}
					}
					// If there arent any previous fields provide one empty one
					else {
						echo '<h4> Behavior 1 </h4>';
						echo '<textarea class="behaviorText" name="behavior[0]" rows="2" cols="20"></textarea>';
					}
	
					?>
				</div>
	
				<br />
	
				<p>Additional Comments<p/>
				<textarea wrap="virutal" name="additional" rows="5" cols="50"></textarea>
				<br />
				<input type="hidden" name="studentID" value="<?php echo $studentID; ?>" />
				<input type="hidden" name="prjID" value="<?php echo $prjID ?>" />
				<input type="submit" value='Accept'/>
			</form>
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
					'" class="behaviorText" name="behavior[' + i + ']" rows="2" cols="20"></textarea>';
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
