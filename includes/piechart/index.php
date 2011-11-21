<!-- http://dmitry.baranovskiy.com/work/fiechart/ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Pie Chart (JavaScript edition)</title>
	 <style type="text/css" media="screen">
	 	@import "piechart.css";
	</style>
<!--[if lt IE 7]>
		<style type="text/css" media="screen">
			@import"piechart-ie.css";
		</style>
	<![endif]-->
	<script type="text/javascript" charset="utf-8" src="piechart.js"></script>
	<script type="text/javascript" charset="utf-8" src="ajax.js"></script>
	<script type="text/javascript" charset="utf-8" src="local.js"></script>
	<script type="text/javascript" charset="utf-8" src="sliderSynch.js"></script>
</head>
<body>
	<div id="pie">
		<span id="for-ie"><img src="pie-1.png" alt="" id="circle" /></span>
		<img src="loadb.gif" alt="loading…" id="spinner" />
	</div>
	<form action="#no_javascript-no_fun" id="pie-form">
		<div>
		
		
      
		<?php include"input.php"?>        

			
			
			
			
			<img src="!.png" id="valid" alt="!" />
			<div>
				<!-- <button type="submit"> -->
				<!-- 	<img src="go.png" alt="Update" title="update" /> -->
				<!-- </button> -->
				


				<button type="button" id="perc">
					<img src="percent.png" alt="Percentage view on/off" title="percentage view on/off" />
				</button>

				
				<!-- this is just here cuz the js script is looking for those values -->
				<div id="rot-cc"></div>
				<div id="rot-acc"></div>
			
				
				
				
				<?php include"sliders.php"?>
				
				
				
				
				
				
				
				
				
				<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
         <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
          
          <!-- example im using atm http://www.ryancoughlin.com/2008/11/04/using-the-jquery-ui-slider/#4 -->
          
        
        



				
				
				
				
				
				
				
	
				
				

				
				
			</div>
		</div>
	</form>
</body>
</html>
