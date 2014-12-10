<?php

//get max points, and group size


$output = '';
      for ($j=1; $j < $groupSize; $j++){
  
          
      
      }
      
      
      
      if ($maxPoints%$groupSize == 0)
      {
  
        $firstNumb = floor($maxPoints/$groupSize); 
  
      }
      else
      { 
        $firstNumb = $maxPoints-(floor($maxPoints/$groupSize)*($groupSize-1));
      }
  
     
      $pos1 = $firstNumb;
      $output = $output . $firstNumb . ", ";
      for ($k=2; $k <= $groupSize - 1; $k++)
      {
  	$pos[$k] = floor($maxPoints/$groupSize);  
	$output = $output . $pos[$k] . ", ";
  
      }
	$pos[$groupSize] = floor($maxPoints/$groupSize);
	$output = $output . $pos[$groupSize];
	
	echo '<input id="test" value="' . $output . '" hidden="true"/>' . "\n";
	
