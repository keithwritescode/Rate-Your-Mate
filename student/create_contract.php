<?php include ("../includes/check_authorization.php"); 
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

$prjID = $_SESSION['prjID'];
$creatorQuery = mysql_query( 'SELECT P.ContractCreator FROM Project P WHERE P.PrjID = ' . $prjID . ';' );
if ( $creatorQuery ) {
	$creator = mysql_fetch_array( $creatorQuery );
	$creator = $creator[0];}
else $creator = 0;

if ( $creator != 0 ) {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';	
	exit;
}

$prjNameQuery = mysql_query ('SELECT P.PrjName FROM Project P WHERE P.PrjID = ' . $prjID . ';' );
if ( $prjNameQuery ) {
	$prjName = mysql_fetch_array( $prjNameQuery );
	$prjName = $prjName['PrjName'];
}
else $prjName = '';
$groupID = $_SESSION['groupID'];

?>
<html>
	<head>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
		
		<link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
    	<link rel="stylesheet" type="text/css" href="../css/style.css" />

		<title>Rate Your Mate</title>
	</head>

	<body>
		<div id="header">
			<h1>Create Contract for <?php echo $prjName; ?></h1>
		</div>	

		<div id="menu">
			<?php include ("../includes/student_menu.php"); ?>
		</div>		
		
		<?php
		// Get all behaviors for the group
		$groupQuery = mysql_query ( "SELECT * FROM Behaviors WHERE
						  GrpID = " . $groupID . ";" );
		$numResults = mysql_num_rows( $groupQuery );

		// Get all other contract info
		$contractInfoQuery = mysql_query ( "SELECT * FROM ContractInfo WHERE 
			GrpID = " . $groupID . ";" );
		$contractInfo = mysql_fetch_array ( $contractInfoQuery );
		?>



		<div id="content">
			<form id="contractsetup" name="contractsetup" action="submitcontract.php" method="post">
				<div id="border1">					
					<p> Group Goals </p>
					<textarea wrap="virutal" name="groupGoals" rows="5" cols="50"> <?php echo trim( $contractInfo['Goals'] ); ?> </textarea>
				</div>	
				<div id="behaviors" class='behaviors'>
					<p> How many behaviors will the contract contain? </p>
					<input type="number" id="groupText" name="numBehaviors" value="<?php
						if ($numResults > 0)
							echo $numResults;
						else
							echo 1; ?>" 
						size="4" min="1" max="6"/>
			
					<?php
					// Write in all behaviors
					$i=1;
					if ( $numResults > 0 ) {
						while ( $row = mysql_fetch_array($groupQuery) ) {
							echo '<h4> Behavior ' . $i . ' </h4>';
							echo '<textarea class="behaviorText" name="behavior['.$i++.']" rows="2" cols="20">'.
								trim( $row['Description'] ) . '</textarea>';								}
					}
					// If there arent any previous fields provide one empty one
					else {
						echo '<h4> Behavior 1 </h4>';
						echo '<textarea class="behaviorText" name="behavior[0]" rows="2" cols="20"></textarea>';
					}
	
					?>
				</div>
				<br />

	

			<div id="border1">
					<p>Additional Comments<p/>
					<textarea wrap="virutal" name="additional" rows="5" cols="50"> <?php echo trim( $contractInfo['Comments'] ); ?> </textarea>
					<br />
					<input type="hidden" name="prjID" value="<?php echo $prjID; ?>" />
					<input type="hidden" name="groupID" value="<?php echo $groupID; ?>" />
			</div>
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
