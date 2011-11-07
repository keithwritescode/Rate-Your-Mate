<?php

  $groupSize = 4;
  echo '<br>';
  for ($i=1; $i<=$groupSize; $i++)
  {
    echo ('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>');
    echo   ('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>');
    echo   '<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>';
    echo     '<style type="text/css">';
    echo     '#slider { margin: 10px; }';
    echo   '</style>';
    
    echo '<div id="names">';
    echo  $i;
    echo '</div>';
    echo '<div id="slider' . $i . '">';
    echo  '<script>';
 
    echo   '$(document).ready(function() {';
    echo     '$("#slider' . $i . '").slider();';
    echo   '});';
    echo   '</script>';
    echo '</head>';
    echo '<body style="font-size:62.5%;">';
  
    echo '</div>';
    echo ('<br>'); 
  }
?>
