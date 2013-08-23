<html>
<body>

<form action="BlogEditor.php" method="post"
enctype="multipart/form-data">

<?php
//include php script with database login info
include 'writeBlog.php'; 
$SUBMIT_NOT_PRESSED = 0;
$EMPTY_USER = 1;
$EMPTY_PASS = 2;
$checkUser = true;
$checkUserHandler = 0;
$user = "";
$pass = "";
if ( isset($_POST["user"]) ) $user = $_POST["user"];
if ( isset($_POST["passw"]) ) $pass = $_POST["passw"];
If ((!checkInput($user, $MAXUSERLEN)) || (!checkInput($pass, $MAXPASSLEN))){
	$checkUser = false;
}



echo "User: <input type='text' name='user' value='$user'> 
Password: <input type='password' name='passw' value='$pass'>
<hr>
<br>
Title: <input type='text' size='50' name='title'>
<br>
<textarea rows='30' cols='80' name='bentry'>

</textarea>
<br>

Pictures to Upload:
<div id='PicUpload'>
<label for='file'>Picture:</label>
<input type='file' name='Pic1' id='Pic1'>
<br>
</div>
<input type='submit' name='dataSubmit' value='1'>
</form>";
if ($checkUser){
	$blogWrt = new wrtieBlog();
	if ($blogWrt->dbConnect($DatabaseAddress,$DatabasePort,$DatabaseName,$DatabaseUser,$DatabasePass)){
		if ($blogWrt->checkBlogLogin($user,$pass)){
			echo "Username is valid<br>";
			$blogWrt->writeBlog($UserID, $_POST["title"],$_POST["bentry"]);
		}
	}
}
//call database connect function with parameters set in dbConfig.php
/*$DBConnection = dbConnect($DatabaseAddress,$DatabasePort,$DatabaseName,$DatabaseUser,$DatabasePass);
if (!isset($DBConnection)){
	echo "Cannot connect to database<br>";
	exit;
}
if ( ($checkUser) && (checkBlogLogin($DBConnection,$user,$pass)) ){
	echo "Username is valid<br>";
}
else*/
?>
</body>
</html>