<!-- http://dmitry.baranovskiy.com/work/fiechart/ --!>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Pie Chart (JavaScript edition)</title>
	<style type="text/css" media="screen">
		@import"piechart.css";
	</style>
	<!--[if lt IE 7]>
		<style type="text/css" media="screen">
			@import"piechart-ie.css";
		</style>
	<![endif]-->
	<script type="text/javascript" charset="utf-8" src="piechart.js"></script>
	<script type="text/javascript" charset="utf-8" src="ajax.js"></script>
	<script type="text/javascript" charset="utf-8" src="local.js"></script>
</head>
<body>
	<div id="pie">
		<span id="for-ie"><img src="pie-1.png" alt="" id="circle" /></span>
		<img src="loadb.gif" alt="loading…" id="spinner" />
	</div>
	<form action="#no_javascript-no_fun" id="pie-form">
		<div>
			<input type="hidden" id="test" value="2, 5, 10, 1" />
			<img src="!.png" id="valid" alt="!" />
			<div>
				<button type="submit">
					<img src="go.png" alt="Update" title="update" />
				</button>

				<button type="button" id="perc">
					<img src="percent.png" alt="Percentage view on/off" title="percentage view on/off" />
				</button>

				
				<button type="button" id="rot-cc">
				<!-- 	<img src="rot2.png" alt="Rotate clockwise" title="rotate clockwise" /> -->
				</button>
				<button type="button" id="rot-acc">
				<!--	<img src="rot1.png" alt="Rotate anti-clockwise" title="rotate anti-clockwise" /> -->
				</button> 
				
				<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
          <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
          <style type="text/css">
            #slider { margin: 10px; }
          </style>
          <!-- example im using atm http://www.ryancoughlin.com/2008/11/04/using-the-jquery-ui-slider/#4 -->
          <script>
            $(document).ready(function() {
              $("#slider1").slider({
              handle: '#slider-handle',
              slide: var mypos = $('#slider-bar').slider("value"),
              min:0,
              max:20,
              
              
            })
            });
          </script>
        </head>
        <body style="font-size:62.5%;">
  
        <div id="slider"></div>
        
        
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
          <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
          <style type="text/css">
            #slider { margin: 10px; }
          </style>
          <script>
            $(document).ready(function() {
              $("#slider2").slider(){
              slide: $value2 = ui.value;              
              min: 0'
              max: 20'
              
            }
              
            });
          </script>
        </head>
        <body style="font-size:62.5%;">
  
        <div id="slider"></div>
				
				
				
				
				
				
				
				<!-- <?php include("sliders.php"); ?> will add this after I get a slider working the way it should first -->
				
				

				
				
			</div>
		</div>
	</form>
</body>
</html>
