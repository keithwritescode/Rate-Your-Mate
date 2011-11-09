$(document).ready(function() {

	$('#groupText').keyup(function() {
		var num = new Number( $('#groupText').attr('value') );
		var max = $( '#groupText' ).attr( 'max' );

		if ( num > max ) {
			$( '#groupText' ).attr( 'value', max )	
		}
		$( '#groupText' ).click();
		
	});


    $('#groupText').click(function() {
        var num = $( '.group' ).length;
        var newNum = new Number( $('#groupText').attr('value') );
        newNum = Math.round(newNum);    // If a non-whole number was entered, round
 
	// If adding to the form
        if ( num < newNum ) {
			
            // If the new number is greater, add form elements
            for ( var i = num + 1; i <= newNum; i++ ) {   
			var insertHtml = '<h3><a href="#"> Group ' + i + '</a> </h3>' +
							 '<div id="groups-' + i + '" class="group">' +
								'<ul id="g' + i + '" class="dragging dropping">' + 
									'<li class="placeholder"> Drag names here </li>' +
								'</ul>'+
							 '</div>';

			// Add the new tab
			$('.groups').append(insertHtml);
			// Make the new table droppable
			makeDrop('#groups-'+i);
			// Recreate the accordion with the new group
			
			}
			$('#groups').accordion('destroy').accordion(); 
        }
		else if ( num > newNum ) {
						
			for ( var i = num; i > newNum; i-- ) {
				// add the stuff from the old list to the roster
				$('#g' + i + ' li' ).appendTo('#rosterList');
				$('#groups-' + i).remove();
				$('#groups h6:last-child').remove();
			}
			// Remove any place holders that may have been put on the roster
			$('#rosterList .placeholder').remove();
			$('#groups').accordion('destroy').accordion();
		}
   });

   $('#numEval').keyup(function() {
   	var num = $( '.submitDate' ).length;
        var max = $( '#numEval' ).attr( 'max' );
        if ( num > max )
        	$( '#numEval' ).attr( 'value', max )
                $( '#numEval' ).click();
   });


    $( '#numEval' ).click( function() {
	var num = $( '.submitDate' ).length;
	var newNum = new Number( $( '#numEval' ).attr( 'value' ) );
	newNum = Math.round( newNum );

	if ( num < newNum ) {
		for ( var i = num + 1; i <= newNum; i++ ) {
			var insertHtml = '<div class="submitDate">' +
                        			'<h4> Evaluation ' + i + '</h4>' +
                        			'Evaluatior: <br /> Available From' +
                        			'<input class="avail" />' +
                        			'Due Date' +
                        			'<input class="due" />' +
                        			'<br /> Evaluatee: <br />Available From' +
                        			'<input class="avail" />' +
                        			'Due Date' +
                        			'<input class="due" />'
                				'</div>';
			$( '#submitDate' ).append( insertHtml );

	                $( ".avail" ).datepicker({ minDate: 0, maxDate: "+9M"});
        	        $( ".due" ).datepicker({ minDate: 0, maxDate: "+9M"});

		}
	}
	else if ( num > newNum ) {
		for ( var i = num; i > newNum; i-- ) {
			$('.submitDate:last').remove();
		}
	}
   });
     
});

function makeDrop (id) {
$(id + " ul").droppable({
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
			'" class="ui-draggable">' + ui.draggable.html()+"</li>" + 
                        '<input type="hidden" name="groups[' + this.id + '][' +
                        elem.children().length + ']" value="' +
                        ui.draggable.attr('id') + '" />' +
                        '</li>').appendTo(this);
		// Make the new list object draggable
		$('#' + this.id + ' li').draggable({
			appendTo: "body",
			helper: "clone"
		});
					
	}
});
}
