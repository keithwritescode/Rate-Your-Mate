<?php include ("../includes/check_authorization.php"); 
error_reporting(-1);

include ("../includes/config.php");
include ("../includes/opendb.php");

$prjID = $_SESSION['prjID'];
// Get the name of the project
$prjNameQuery = mysql_query ('SELECT P.PrjName FROM Project P WHERE P.PrjID = ' . $prjID . ';' ) or die( 'ERROR: Could not retrieve project name' );
$prjName = '';
if ( $prjNameQuery ) {
	$prjName = mysql_fetch_array( $prjNameQuery );
	$prjName = $prjName['PrjName'];
}

// Assign the current group
if ( !empty( $_POST['groupID'] ) )
	$_SESSION['GrpID'] = $_POST['groupID'];
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
			<?php include ("../includes/instruct_menu.php"); ?>
		</div>		

		<div id="content">
		<div id="border">
			<?php
			// Get all groups for this project
			$groupIDQuery = mysql_query ( " SELECT DISTINCT G.GrpID FROM Groups G WHERE
                                G.PrjID = ".$prjID) or die ( 'ERROR: Could not retrieve the groups for this project' );
			$cnt = 1;
			?>
			
			<form id='groupSelectForm' name='form' action="view_contract.php" method="post">
			<select name="groupID" onchange='this.form.submit()'>
			
			<?php
			if ( $groupIDQuery ) {
				while ( $groupID = mysql_fetch_array ( $groupIDQuery ) ) {
					print_r($groupID);
					$groupIDArr[$cnt] = $groupID['GrpID'];
					if ( $_SESSION['GrpID'] == $groupID['GrpID'] )
						$defaultString = 'selected="selected"';
					else $defaultString = '';
					if ( empty( $_SESSION['GrpID'] ) ) 
						$_SESSION['GrpID'] = $groupID['GrpID'];
					echo '<option value="' . $groupID['GrpID'] . '" ' . $defaultString . '> Team ' . $cnt++ . '</option>';
				}
			}
			else { ?>
				<select> No groups found </select>
			<?php } ?> 
			</select>
			</form>
			<?php
			// If the groupID is not empty, print the names of the people in the group based of the roster in $_SESSION
			if ( empty( $_SESSION['GrpID']	) ) {}
			else { 
			echo '<h4> Team Members </h4>';

			// Get the ID's of all group members
			$groupSdtIDQueryString = ( 'SELECT G.StudentID FROM Groups G WHERE G.GrpID = ' . $_SESSION['GrpID'] ); 
			$groupSdtIDQuery = mysql_query( $groupSdtIDQueryString ) or die( 'Could not retrieve the list of group members' );
			if ( $groupSdtIDQuery) {
				while ( $studentID = mysql_fetch_array( $groupSdtIDQuery ) ) {
					foreach ( $_SESSION['roster'] as $student ) {
						if ( $student['id'] == $studentID['StudentID'] ) 
							echo '<li>' . $student['name'] . '</li>';
					}
				}
			}
			// Get all behaviors for the group
			$groupQuery = mysql_query( " SELECT * FROM Behaviors WHERE
                              GrpID = " . $_SESSION['GrpID'] . ";" );
			$numResults = mysql_num_rows( $groupQuery ) or die ( 'Could not retrieve the behavior list for the group, contract may not exist' );
			
			// Get all other contract info
			$contractInfoQuery = mysql_query (" SELECT * FROM ContractInfo WHERE 
				GrpID = " . $_SESSION['GrpID'] . ";" );
			$contractInfo = mysql_fetch_array ( $contractInfoQuery )or die ( 'Could not retrieve contract info list for the group, contract may not exist' );
			?>
		</div>

		<div id="border1">
			<h4> Group Goals </h4>
			<textarea readonly="readonly" wrap="virutal" name="groupGoals" rows="5" cols="50"> <?php echo $contractInfo['Goals']; ?> </textarea>
			
						
			<div id="behaviors" class="behaviors">
				<?php
				// Write in all behaviors
				$i = 1;
				if ( $numResults > 0 ) {
					while ( $row = mysql_fetch_array($groupQuery) ) {
						echo '<h3> Behavior ' . $i . ' </h3>';
						echo '<textarea readonly="readonly" class="behaviorText" name="behavior['.$i++.']" rows="2" cols="20">'.
							$row['Description'] . '</textarea>';								}
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
			<textarea readonly="readonly" wrap="virutal" name="additional" rows="5" cols="50"> <?php echo $contractInfo['Comments']; ?> </textarea>			<?php } ?>
		</div>
		</div>
	</body>
</html>
