function sliderSynch (sliderNumb, ui)
{
  //console.log(sliderNumb);
  var nextSlider = 0;
	var totalSum = getSliderTotal();
	var sliderEval = "#slider" + sliderNumb;
	var currentSliderValue = ui.value;
	var previousSliderValue = old_pos[sliderNumb];
	
	var nextSliderValue = 0;
	var posVar;
   
	if (currentSliderValue > previousSliderValue)
	{
	// next slider needs to go down
    nextSlider = getNextSlider(sliderNumb, true);
    pos[nextSlider] = pos[nextSlider]-1;
    
    //$('.sliders').each(function(k) {
     //     $("#slider" +k).slider( "value", pos[k]);
      //  });
  }
	else if (currentSliderValue < previousSliderValue)
	{
    nextSlider = getNextSlider(sliderNumb, false);
    pos[nextSlider] =  pos[nextSlider]+1;
     //console.log("zach likes monkeys");
	   //next slider needs to go right
	  // 
    //$("#slider1").slider("value", 1); 
  }
  //console.log("previousSliderValue " + previousSliderValue);
}

function correctValues()
{
  var currentTotal = getSliderTotal();
  var difference = currentTotal - maxPoints;
  console.log (difference);
  var k = 0;
  if (currentTotal != maxPoints)
  {
    //console.log("in the first if");
    //console.log("currentTotal: " + currentTotal + " maxPoints: " + maxPoints);
    var lowNum = 0;
    var highNum = 999999;
    if (currentTotal > maxPoints)
    {
      console.log("in the too many points if");
      $('.sliders').each(function(i) {
         if (pos[i] > lowNum)
         {
            lowNum = i;
         }
      });
      //console.log("slider that is too high: " + lowNum);
      console.log("k is: " +k);
      k++;
      pos[lowNum] = pos[lowNum] - difference;
      $("#slider" + lowNum).slider( "value", (pos[lowNum] - difference));
     // pc.setValues(pos);
      
    }
    if (currentTotal < maxPoints)
    {
      console.log("in the too few points if");
      $('.sliders').each(function(i) {
         if (pos[i] < highNum)
         {
            highNum = i;
         }
      });
      //console.log("slider that is too low: " + highNum);
      pos[highNum] = pos[highNum] - difference;
      $("#slider" +highNum).slider( "value", (pos[highNum] - difference));
     // pc.setValues(pos);
    }  
  }
  else
  {
    //console.log("the value is correct!");
  }
  
}

function getSliderTotal() {
  var totalSum = 0;
	$('.sliders').each(function(index) {
			totalSum += $(this).slider( "option", "value" );	
	});
	return totalSum;
}

function getNextSlider(sliderNumb, addition_bool)
{
  if (sliderNumb == (groupSize - 1))
	{
	   //last slider 
     nextSlider = 0;
  }
  else
  {
    // normal case
     nextSlider = (sliderNumb + 1);
  }
  
  if((addition_bool && pos[nextSlider]==1) || ( pos[nextSlider]==maxPoints ) )
  {
    // recursion, case that the slider is all the way gone.
    // need a different case when they are maxed (or perhaps handle differntly for addition?subtraction!
    return getNextSlider(nextSlider, addition_bool);
  }
  
  return nextSlider;
}


function createSliders(num_groups, max_num) {

  $('.sliders').each(function(i) {
    $("#slider" +i).slider({
      value: pos[i],
      stop: function (e, ui){
        correctValues();
        pc.setValues(pos);
      },
      slide: function (e, ui){

        // clone the pos array so that we have it's original values available
        old_pos = pos.slice(0);
        pos[i] = ui.value;
        sliderSynch(i, ui);
        
        $('.sliders').each(function(k) {
          $("#slider" +k).slider( "value", pos[k]);
        });
                
        pc.setValues(pos);
        
      },
      min: 1,
      max: (max_num - (num_groups - 1))
      
    })
  });
  
}
