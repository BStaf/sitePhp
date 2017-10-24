<?php

	echo '
	<div id="titleBox">
		<img STYLE="position:absolute; TOP:5px; LEFT:5px;"  src="/mySite/pics/BBTitle.png" alt="ALT!!!!">
		<h5 STYLE="position:absolute; TOP:30px; LEFT:5px;">Technodrome 3AM</h5>
	</div>';
	echo '
	<div id="menu">
		<ul>
			<li class="menuList"><a href="myPage.php" class="menuLink">Home</a></dt>
			<li class="menuList"><a href="robots.php" class="menuLink">Robot Builds</a></dt>
			<li class="menuList"><a href="sProjects.php" class="menuLink">Software Projects</a></dt>
		</ul>
	</div>';
	echo '
	<div id="contactBox">
		Email: <a href="mailto:mail@gmail.com">will.staf@gmail.com</a><br>
		<a href="http://www.facebook.com/*****"><img style="position:relative; top:-2px;" src="/mySite/pics/facebook.png" width="27" height="26" /></a>
		<a href="http://www.linkedin.com/****"><img class="button" src="/mySite/pics/linkedin.png" width="30" height="30" /></a>
		<br>
	</div>';
	
	function mainPage(){
		echo '
			<div id= "contentBox">
				<center>
				<img src="/mySite/pics/Me.jpg" height="50%" width="50%" alt="ALT!!!!">
				</center>
				<br>
				Welcome to my own little site where I can post some of my projects. Try not to get too bored.
				<br><br><br><br>
			</div>
		';
	}
?>
