<?php include ("../includes/check_authorization.php");
error_reporting(-1);

// Connect to the database
include ("../includes/config.php");
include ("../includes/opendb.php");

?>

<html>
<head>
    <title> Instructor Setup </title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
    <script src="../js/instructor_setup.js">    </script>
    <link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>

<body>
   <?php $totalPoints = 25 ?>
   <form id="instructor_setup" name="instructorsetup"
            action="updateInstruct.php" method="post"  >
	<p> Name 1 
	<input type="range" class="score" id="1" name=score[1] value="6" min="0" max="25" onchange='changeScore("1")'/> </p>
	<p> Name 2 
	<input type="range" class="score" id="2" name=score[2] value="6" min="0" max="25" onchange="changeScore(2)"/> </p>
	<p> Name 3 
	<input type="range" class="score" id="3" name=score[3] value="6" min="0" max="25" onchange="changeScore(3)"/> </p>
	<p> Name 4 
	<input type="range" class="score" id="4" name=score[4] value="7" min="0" max="25" sonchange="changeScore(4)"/> </p>
   </form>
</body>

<script>

// Make all lists droppable
function changeScore (id) {
	// Get the total number of scores
	var scoreLength = $( '.score' ).length;
	// Total number of points
	var totalPoints = <?php echo $totalPoints; ?> ;

	var startingPoint = 0;
	var total = 0;
	// Get the sum of all the boxes
	for( var i = 1; i < scoreLength; i++ ) {
		// Save the starting point
		if ( '#' + id == '#' + i ) {
			startingPoint = i;
		}
		// Get the sum of all the boxes
		var newScore = new Number( $('#' + i).attr('value') );

		total += newScore;		
	}
	
	// Subtract from the next one
	if ( total > totalPoints ) {
		var curr = startingPoint + 1;
		var diff = total - totalPoints;
		if ( curr > scoreLength ) {
			curr = 1;
		}
		while ( curr != startingPoint ) {
			// Decrement the one below down to 0
			var changeScore = new Number( $('#' + curr).attr('value') );				
			
			// If all of it can be subtracted from the next one, do it
			if ( diff <= changeScore ) {
				$('#' + curr).attr( 'value', changeScore - diff );
				break;
			}
			// Else subtract what you can then move on
			else {
				diff = diff - changeScore;
				$('#' + curr).attr( 'value', 0 );
			}
			curr++;
			// Bring back around to the first slider
			if ( curr > scoreLength ) {
				curr = 1;
			}
		}
	}
	// Subtract from the next one
	if ( total < totalPoints ) {
		var curr = startingPoint + 1;
		var diff = totalPoints - total;
		if ( curr > scoreLength ) {
			curr = 1;
		}
		while ( curr != startingPoint ) {
			// Decrement the one below down to 0
			var changeScore = new Number( $('#' + curr).attr('value') );				
			
			// If all of it can be added from the next one, do it
			if ( diff <= totalPoints - changeScore ) {
				$('#' + curr).attr( 'value', changeScore + diff );
				break;
			}
			// Else add all and move on
			else {
				diff = diff - changeScore;
				$('#' + curr).attr( 'value', totalPoints );
			}
			curr++;
			// Bring back around to the first slider
			if ( curr > scoreLength ) {
				curr = 1;
			}
		}
	}
}
</script>

</html>
