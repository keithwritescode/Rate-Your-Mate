<?php include ("../includes/check_authorization.php"); 
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

$prjID = $_SESSION['prjID'];

// Get the name of the project
$prjNameQuery = mysql_query ('SELECT P.PrjName FROM Project P WHERE P.PrjID = ' . $prjID . ';' );
$prjName = mysql_fetch_array( $prjNameQuery );
$prjName = $prjName['PrjName'];

	
// Write in all behaviors
$groupQuery = mysql_query( " SELECT * FROM Behaviors WHERE
				  GrpID = " . $_SESSION['groupID'] . ";" );
$numResults = mysql_num_rows( $groupQuery );

// Get all other contract info
$contractInfoQuery = mysql_query ('SELECT * FROM ContractInfo WHERE 
	GrpID = ' . $_SESSION['groupID'] . ';' );
$contractInfo = mysql_fetch_array ( $contractInfoQuery );
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
			<h1>View Contract for <?php echo $prjName; ?></h1>
		</div>	

		<div id="menu">
			<?php include ("../includes/student_menu.php"); ?>
		</div>		

		<div id="content">

		<div id="border1">
			<h4> Group Goals </h4>
			<textarea readonly="readonly" wrap="virutal" name="groupGoals" rows="5" cols="50"> <?php echo trim( $contractInfo['Goals'] ); ?> </textarea>
				
			<div id="behaviors" class="behaviors">
				<?php			
				$i = 1;
				if ( $numResults > 0 ) {
					while ( $row = mysql_fetch_array($groupQuery) ) {
						echo '<h3> Behavior ' . $i . ' </h3>';
						echo '<textarea readonly="readonly" class="behaviorText" name="behavior['.$i++.']" rows="2" cols="20">'.
							trim( $row['Description'] ) . '</textarea>';								
					}
				}
				// If there arent any previous fields provide one empty one
				else {
					echo '<h5>  Behavior 1 </h5>';
					echo '<textarea readonly="readonly" class="behaviorText" name="behavior[0]" rows="2" cols="20"></textarea>';
				}
				?>
			</div>
		
			<br />
	
			<h3>Additional Comments</h3>
			<textarea readonly="readonly" wrap="virutal" name="additional" rows="5" cols="50"> 
				<?php echo trim ( $contractInfo['Comments'] ); ?> 
			</textarea>
		</div>
		</div>
	</body>
</html>
