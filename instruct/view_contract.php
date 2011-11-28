<?php include ("../includes/check_authorization.php"); 
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

$studentID = 4;
$prjID = $_SESSION['prjID'];
// Get the name of the project
$prjNameQuery = mysql_query ('SELECT P.PrjName FROM Project P WHERE P.PrjID = ' . $prjID . ';' );
$prjName = mysql_fetch_array( $prjNameQuery );
$prjName = $prjName['PrjName'];

?>
<html>
	<head>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>

		<title>Rate Your Mate</title>

	</head>

	<body>
		<div id="head">
			<h2>View Contract for <?php echo $prjName; ?></h2>
		</div>	

		<div id="menu">
			<?php include ("../includes/student_menu.php"); ?>
		</div>		

		<div id="content">
			<?php
			// Get all groups for this project
			$groupIDQuery = mysql_query ( " SELECT G.GrpID FROM Groups G WHERE
                                G.PrjID = ".$prjID);
			$cnt = 1;
			echo '<select name="groupID">';
			while ( $groupID = mysql_fetch_array ( $groupIDQuery ) ) {
				$groupIDArr[$cnt] = $groupID['GrpID'];
				$defaultString = "";
				echo '<option value="' . $groupID['GrpID'] . '" ' . $defaultString . '> Team ' . $cnt++ . '</option>';
			}
			echo '</select>';
			// If the groupID is not empty, print the names of the people in the group based of the roster in $_SESSION
			if ( empty( $_SESSION['GrpID']	) ) {}
			else { 
			echo '<h4> Team Members </h4>';


			// Get the ID's of all group members
			$groupSdtIDQueryString = ( 'SELECT G.StudentID FROM Groups G WHERE G.GrpID = ' . $_SESSION['GrpID'] ); 
			$groupSdtIDQuery = mysql_query( $groupSdtIDQueryString );
			while ( $studentID = mysql_fetch_array( $groupSdtIDQuery ) ) {
				print_r($_studentID);
			}
			// Get all behaviors for the group
			$groupQuery = mysql_query( " SELECT * FROM Behaviors WHERE
                              GrpID = " . $groupID . ";" );
			$numResults = mysql_num_rows( $groupQuery );
			
			// Get all other contract info
			$contractInfoQuery = mysql_query (" SELECT * FROM ContractInfo WHERE 
				GrpID = " . $groupID . ";" );
			$contractInfo = mysql_fetch_array ( $contractInfoQuery );
			?>
			<h4> Group Goals </h4>
			<textarea readonly="readonly" wrap="virutal" name="groupGoals" rows="5" cols="50"> <?php echo $contractInfo['Goals']; ?> </textarea>
			
			<div id='behaviors' class='behaviors'>
				<?php
				// Write in all behaviors
				$i = 1;
				if ( $numResults > 0 ) {
					while ( $row = mysql_fetch_array($groupQuery) ) {
						echo '<h4> Behavior ' . $i . ' </h4>';
						echo '<textarea readonly="readonly" class="behaviorText" name="behavior['.$i++.']" rows="2" cols="20">'.
							$row['Description'] . '</textarea>';								}
				}
				// If there arent any previous fields provide one empty one
				else {
					echo '<h4> Behavior 1 </h4>';
					echo '<textarea readonly="readonly" class="behaviorText" name="behavior[0]" rows="2" cols="20"></textarea>';
				}
				?>
			</div>
	
			<br />
	
			<h4>Additional Comments</h4>
			<textarea readonly="readonly" wrap="virutal" name="additional" rows="5" cols="50"> <?php echo $contractInfo['Comments']; ?> </textarea>
			<?php } ?>
		</div>
	</body>
</html>
