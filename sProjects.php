<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="format.css" />
<script src="js/boxClass.js"></script>
<script src="js/JSAnimations.js"></script>
<script src="js/boxes.js"></script>
<script src="js/BlocksGame.js"></script>
<!--<script src="js/testScript.js"></script>-->
<script>
	var appSelected = 0;
	
	function reloadDiv(divname,newHTMLStr){
		document.getElementById(divname).innerHTML=newHTMLStr;
	}
	function showHTML5(appIndex){
		canvasAr = new Array( 
			"<img class='button' src='pics\\softthumbs\\blocks.jpg' width='320' height='390' onclick='showHTML5(1)'>",
			"<img class='button' src='pics\\softthumbs\\blockGame.jpg' width='320' height='420' onclick='showHTML5(2)'>"
			);
		switch (appIndex){
			case 0:
				break;
			case 1:
				var canvStr = "<canvas id='boxesScreen' width='320' height='390' style='background:white;'>" +
					"<p>Your browser doesn't support canvas.</p>" +
					"</canvas>";
					
					
				document.getElementById("canvas"+appIndex.toString()).innerHTML=canvStr;
				BoxesApp.runApp('boxesScreen');
				break;
			case 2:
				var canvStr = "<canvas id='boxGameScreen' width='320' height='420' style='background:#99AAAA;'>"+
					"<p>Your browser doesn't support canvas.</p>"+
					"</canvas>";
				document.getElementById("canvas"+appIndex.toString()).innerHTML=canvStr;
				BoxGameApp.runApp('boxGameScreen');
				break;
		}
		for (var i=1;i<=canvasAr.length;i++){
			if (i != appIndex){
				var TempStr = canvasAr[i-1];
				document.getElementById("canvas"+i.toString()).innerHTML=TempStr;
			}
		}
	}
			

</script>
</head>
<body>
	
<div id="InnerPage">
	<?php 
		include 'format.php'; 
	?>
	<div id= "contentBox">

		<div id="ContentItem" style="height:530px;">
			<H3>Clickable Boxes Example:</H3>
			<H4>Simple app demostrating canvas animation and mouse input handling.
			All boxes will grow if clicked on and shrink when clicked again.</H4>
			<br>
			<center>
			<div id="canvas1">
				<!--<canvas id='boxesScreen' width='320' height='390' style='background:white;'>
				<p>Your browser doesn't support canvas.</p>
				</canvas>
				<script>BoxesApp.runApp('boxesScreen')</script>-->
				<img class='button' src='pics\\softthumbs\\blocks.jpg' width='320' height='390' onclick='showHTML5(1)'>
			</div>

			</center>
		</div>
		<div id="ContentItem" style="height:530px;">
			<H3>Box based Puzzle Game:</H3>
			<H4>Utilizes the same box  Object as the Clickable Boxes Example.
			You can drag a blue box onto the puzzle board. Any rd box can be moved
			out of the way as long as no other blocks lay on either side of it.
			This is still a work in progress. </H4>
			<br>
			<center>
			<div id="canvas2">
				<img class='button' src='pics\\softthumbs\\blockGame.jpg' width='320' height='420' onclick='showHTML5(2)'>
			</div>
			<!--<canvas id="boxGameScreen" width="320" height="420" style="background:#99AAAA;position:relative;">
				<p>Your browser doesn't support canvas.</p>
			</canvas>
			</div>
			<script> 
				BoxGameApp.runApp('boxGameScreen');
			</script>-->
			</center>
		</div>
		<!--<script>showHTML5(0);</script> -->
	</div>
	
</div>
</body>
</html>