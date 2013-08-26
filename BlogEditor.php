<html>
<body>

<form action="BlogEditor.php" method="post"
enctype="multipart/form-data">
<script>

function addNewPicEntry(){
	var createEntry = false;
	addNewPicEntry.picCnt++;
	var numStr = addNewPicEntry.picCnt.toString();
	if (addNewPicEntry.picCnt == 1) createEntry = true;
	else if (document.getElementById("Pic1").value != null) createEntry = true;
	
	if (createEntry){
		var container = document.createElement("div");
		container.innerHTML = "<label for='file'>Picture "+numStr+":</label>\n<input type='file' name='Pic"+numStr+"' id='Pic"+numStr+"' onChange='addNewPicEntry()'><br>";
		document.getElementById("PicUpload").appendChild(container); 
		//document.getElementById("PicUpload").innerHTML+="<label for='file'>Picture "+numStr+":</label>\n<input type='file' name='Pic"+numStr+"' id='Pic"+numStr+"' onChange='addNewPicEntry()'><br>";
	}
}
addNewPicEntry.picCnt = 0;
</script>
<?php
//include php script with database login info
include 'dbBlog.php'; 
$SUBMIT_NOT_PRESSED = 0;
$EMPTY_USER = 1;
$EMPTY_PASS = 2;
$checkUser = true;
$checkUserHandler = 0;
$user = "";
$pass = "";
$title = "";
$data = "";
if ( isset($_POST["user"]) ) $user = $_POST["user"];
if ( isset($_POST["passw"]) ) $pass = $_POST["passw"];
If ((!checkInput($user, $MAXUSERLEN)) || (!checkInput($pass, $MAXPASSLEN))){
	$checkUser = false;
}
if ( isset($_POST["title"]) ) $title = $_POST["title"];
if ( isset($_POST["bentry"]) ) $data = addslashes($_POST["bentry"]);

echo " User: <input type='text' name='user' value='$user'> 
Password: <input type='password' name='passw' value='$pass'>
<hr>
<br>
Title: <input type='text' size='50' name='title' value='$title'>
<br>
<textarea rows='30' cols='80' name='bentry' value='$data'>

</textarea>
<br>";
?>
Pictures to Upload:

<div id='PicUpload'></div>
<script>addNewPicEntry();</script>
<!--<label for='file'>Picture 1:</label>
<input type='file' name='Pic1' id='Pic1' onChange='addNewPicEntry()'>
<br>
</div>-->
<input type='submit' name='dataSubmit'>
</form>

<?php
if ($checkUser){
	$blogWrt = new dbBlog();
	if ($blogWrt->dbConnect($DatabaseAddress,$DatabasePort,$DatabaseName,$DatabaseUser,$DatabasePass)){
		if ($blogWrt->checkBlogLogin($user,$pass) > -1){
			echo "Username and password are valid<br>";
			
			if ($blogWrt->writeBlog($user, $_POST["title"],$_POST["bentry"])) echo "Write Succesfull\n";
		}
		else echo "Username and password are invalid<br>";
	}
	else echo "Cannot connect to database to prove login.<br>";
	
}

?>
</body>
</html>