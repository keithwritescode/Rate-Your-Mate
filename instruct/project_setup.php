<?php include ("../includes/check_authorization.php"); 
error_reporting(-1);
?>
<html>
<head>
    <title> Instructor Setup </title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'></script>
    <script src="../js/instructor_setup.js"> 	</script>
    <script src="../js/float_layers.js"> 		</script>  
    <link rel="stylesheet" type="text/css" href="../css/dateStyle.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body> 
    <div id="header">
        <h1> Instructor Setup </h1>
    </div>

   <div id="menu">
      <?php include ("../includes/menu.php"); ?>
   </div>

   <div id="content">
      <form id="instructor_setup" name="instructorsetup" 
            action="updateInstruct.php" method="post"  >
         Project I.D.: <input type="text" name="projectID" />    <br />
         Number of Groups: 
        
         
        <div id="rosterSource" class="dropping" >
			<h4> Roster </h4>
            <ul name="roster" id="rosterList" class="dragging dropping">
				<?php
				foreach ( $_SESSION['roster'] as &$student ) 
				echo '<li id="'.$student['id'].'">'.$student['name'].'</li>';    
				?>
            </ul>
        </div>
			
		<input type="number" id="groupText" name="numGroups" value="2" />
		
		<div id='groups' class='groups' >			
			<h3><a href="#"> Group 1 </a> </h3>
			<div id="groups-1" class="dropping group">
				<ul class="dragging dropping" id="g1">
					<li class='placeholder'> Drag names here </li>
				</ul>
			</div>
			
			<h3><a href="#"> Group 2 </a> </h3>
			<div id="groups-2" class="dropping group">
				<ul class="dragging dropping" id="g2">
					<li class='placeholder'> Drag names here </li>
				</ul>
			</div>
			
		</div>
		
		<div id='contractSubmission' >
			<p> Who submits the contract? </p>
			<input type="radio" name="contractSubmit" value="0" /> Student <br/>
			<input type="radio" name="contractSubmit" value="1" /> Teacher <br/>
		</div>
		<div id='gradeSubmit' >
			<p> Do you want to submit a grade for: </p>
			<input type="radio" name="gradeSubmit" value="0" /> Evaluatee Only <br/>
                        <input type="radio" name="gradeSubmit" value="1" /> Evaluator Only <br/>
                        <input type="radio" name="gradeSubmit" value="2" /> Both Evaluator and Evaluatee <br/>
                        <input type="radio" name="gradeSubmit" value="3" /> None <br/>
	
		</div>		
		<p> Number of points to be allocated </p>
		<input id="pointAlloc" type="number" name="pointAlloc" value="1" size="4" min="1" max="100" />
	
		<p> Number of Evaluations </p>
		<input id="numEval" type="number" name="numEval" value="2" min="1" max="100" />
		<p> Evaluation Dates </p>
		<div id="submitDate">
			<div class="submitDate">
				<h4> Evaluation 1 </h4>
				Evaluatior: <br />
				Available From
				<input class="avail" name="evalt[avail][0]"/> 
				Due Date
				<input class="due" name="evalt[due][0]"/>
				<br /> Evaluatee: <br />Available From 
				<input class="avail" name="evale[avail][0]"/>
				Due Date
				<input class="due" name="evale[due][0]"/>
			</div>
			<div class='submitDate'>
							<h4> Evaluation 2 </h4>
							Evaluatior: <br />
							 Available From
							<input class="avail" name="evalt[avail][1]"/>
							Due Date
							<input class="due" name="evalt[due][1]"/>
							<br /> Evaluatee: <br />Available From
							<input class="avail" name="evale[avail][1]"/>
							Due Date
							<input class="due" name="evale[due][1]"/>
			</div>
		</div>
		<input type="submit" value="Submit" />

      </form>
   </div>
</body>

<script type="text/javascript">
	$(function() {
		$( "#groups" ).accordion();
		$( ".avail" ).datepicker({ minDate: 0, maxDate: "+9M"});
		$( ".due" ).datepicker({ minDate: 0, maxDate: "+9M"});
	});
	// Make all student names draggable
	 $(".dragging li").draggable({
		appendTo: "body",
		helper: "clone"
	});
	// Not working!!!
	$(".dropping ul").droppable({
		activeClass: "ui-state-highlight",
		hoverClass: "ui-state-hover",
		accept: ":not(.ui-sortable-helper)",
		drop: function(event,ui){
			// If the place holder is there, remove it	
			$(this).find( ".placeholder" ).remove();
			var elem = $(this);

			// Remove the element from everywhere else	
			var element = document.getElementById(ui.draggable.attr('id'))
			if (element != null)
				element.parentNode.removeChild(element);	
			// Add it in			
			$('<li id="' + ui.draggable.attr('id') +
				'" class="ui-draggable">' + ui.draggable.html()+
				// Add an input
				'<input type="hidden" name="groups[' + this.id + '][' + 
					elem.children().length + ']" value="' + 
					ui.draggable.attr('id') + '" />' + 
					'</li>').appendTo(this);
			// Make the new list object draggable
			$('#' + this.id + ' li').draggable({
				appendTo: "body",
				helper: "clone"
			});

			// If any ul is empty, put a place holder in it
			$("ul", "#rosterSource").each(
				function() {
					var elem = $(this);
					if (elem.children().length == 0) {
						$('<li class="placeholder"> Drag names here </li>').appendTo(this);
					}
				}
			);
			// If any ul is empty, put a place holder in it
			$("ul").each(
				function() {
					var elem = $(this);
					if (elem.children().length == 0) {
						$('<li class="placeholder"> Drag names here </li>').appendTo(this);
					}
				}
			);			
		}
	});

</script>
</html>


