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
	<input type="number" class="score" id="1" name=score[1] value="6" min="0" max="25"/> </p>
	<p> Name 2 
	<input type="number" class="score" id="2" name=score[2] value="6" min="0" max="25"/> </p>
	<p> Name 3 
	<input type="number" class="score" id="3" name=score[3] value="6" min="0" max="25"/> </p>
	<p> Name 4 
	<input type="number" class="score" id="4" name=score[4] value="7" min="0" max="25"/> </p>
   </form>
</body>

<script>
$(function() {
        changeScore( "#1" );
	changeScore( "#2" );
        changeScore( "#3" );
        changeScore( "#4" );

});
// Make all lists droppable
function changeScore (id) {
	// Keep the number wihin the range no matter what
        $('#' + id).keyup(function() {
		var id = '#' + id;
                var num = new Number( $( id ).attr('value') );
                var max = new Number( $( id ).attr( 'max' ) );

                if ( num > max ) {
                        $( id ).attr( 'value', max )
                }
                $( id ).click();
        });

	$('#' + id).click(function() {
		// Get the total number of scores
	        var length = $( '.score' ).length;
		// Total number of points
		var totalPoints = <?php echo $totalPoints; ?>

		// Get the sum of all the boxes
		var newScore = new Number( $('#groupText').attr('value') );
        		newNum = Math.round(newNum); 

		// Start subtracting from the boxes directly below,
		// If it hits 0, go to the next box
		// When you go to the bottom loop up to the top
		// Once all others are 0, the one being clicked must have all the points
		
	});

}
</script>

</html>
