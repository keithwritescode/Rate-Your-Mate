<?php
//need to grab maxPoints and groupSize from the data base.
//$maxPoints = 44;
//$groupSize = 11;

$output = '';
for ($j=0; $j < $groupSize-1; $j++){
  $output = $output . 'pos[' . ($j) . ']+ ", " + ';    
}
$output = $output . 'pos[' . ($j) . "];\n";

?>

<!-- much of this pie chart was based off of the pie chart found at http://dmitry.baranovskiy.com/work/fiechart/ -->
<style type="text/css">
.sliders { margin: 1.5em;}
</style>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript">
var maxPoints = <?php echo $maxPoints; ?>;
var groupSize = <?php echo $groupSize; ?>;
var pos = new Array();
var old_pos = new Array();

$(document).ready(function() {
  var test = $('#test');
  var pc = new PieChart();

  createSliders(<?php echo $groupSize;?>, <?php echo $maxPoints; ?>);
  <?php
      
  if ($maxPoints%$groupSize == 0)
  {
    $firstNumb = floor($maxPoints/$groupSize); 
  }
  else
  { 
    $firstNumb = $maxPoints-(floor($maxPoints/$groupSize)*($groupSize-1));
  }
  
  echo 'pos[0] = ' . $firstNumb . ";\n";
  echo '$( "#slider0" ).slider( "value", pos[0]);' . "\n";
  
  for ($k=1; $k < $groupSize; $k++)
  {
    echo  "pos[$k] = " . floor($maxPoints/$groupSize) . ";\n";
    echo '$( "#slider' . $k . '" ).slider( "value", pos[' . $k . ']);' . "\n";
  }
  ?>

  pc.setValues(pos);
  test.value = pos;
  
  });
</script>

</head>

<body style="font-size:62.5%;">
<?php
for($i=0; $i<$groupSize; $i++) {
  ?>    
  <div id="slider<?php echo $i;?>" class="sliders"></div>
  <?php
}
?>
<br/>
  <?php

  if($groupSize==1){
    //If group size == 1
      echo   '<style type="text/css">' . "\n";
      echo        '#slider { margin: 10px; }' . "\n";
      echo      '</style>' . "\n";
              
      echo      '<script>' . "\n";
      echo        '$(document).ready(function() {' . "\n";
      echo          '$("#slider' . $groupSize . '").slider({' . "\n";
      	
      echo          'slide: function (e, ui){';
      echo            'var pos' . $groupSize . ' = ui.value;' . "\n"; //sets the variable pos to the number the slider is at.
      
      echo            'test.value = pos' . $groupSize . ';' . "\n";
             
      echo            'eval("initial = [" + test.value + "]");' . "\n"; //this line and the next two update the drawing on the piechart
      echo            'pc.setValues(initial);' . "\n";
      echo            'test.value = initial;' . "\n";
      echo          '},' . "\n";
    
      echo          'min:0,' . "\n";  //min value of the slider
      echo          'max:' . $maxPoints . ',' . "\n";  //max value
      echo        '})' . "\n";
      echo        '});';
      echo      '</script>' . "\n";
      echo     '</head>' . "\n";
      echo    '<body style="font-size:62.5%;">' . "\n";
      
      echo    '<div id="slider' . $groupSize . '" class="sliders"></div>' . "\n";
      echo '<br>' . "\n";
  
  
  
  }
