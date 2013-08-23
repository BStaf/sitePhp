<html>
<body>
<?php
//include php script with database login info
include 'dbConfig.php'; 
//returns true if input is valid
//input string to be tested and max length of that string
//this function does allow alphanumeric, and some special characters, 
//but does not allow "; ( ) "
function checkInput($string, $MaxLen){
	//ctype_alnum($user)
	//check for empty string
	if (empty($string)){return false;}
	//check if string is too long
	if (strlen($string) > $MaxLen){return false;}
	//check for valid characters	
	else if(!preg_match('/^[A-Za-z0-9_~\-!@#\$%\^&\*]+$/',$string)){return false;}
	else {return true;}
}

//database connect function
function dbConnect($DBAddr,$DBPort,$DBName,$DBUser,$DBPass){
	// Connecting, selecting database  
	//if ($DBPort = 0) {$DBPort = 3306;}
	if (!$DBConnect = mysqli_connect($DBAddr,$DBUser,$DBPass,$DBName,$DBPort)) { 
		throw new Exception('Failed to connect to Server' . mysql_error()); 
		exit; 
	} 
	//echo 'Connected successfully'; 
	//if (!mysqli_select_db($DBConect,$DBName)){  
	//	echo('Could not select database');
	//	return -1;
	return $DBConnect;
}

function dbQuery($DBConnect, $Query){
	// Query all pump station data 
	//$query = 'SELECT * FROM LasaData'; 
	if (!$result = mysqli_query($DBConnect,$Query)) {  
		throw new Exception('Query failed: ' . mysql_error()); 
		return -1;
	} 
	return $result;
}
  
//parse data 
//$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
  
//pleasure road data 
//$PR_TotFlow = number_format($row['PleasureRoad.PR_PLC.Global.FMain_Total_Flow']); 	
	
	
$MAXUSERLEN = 15;
$MAXPASSLEN = 30;
$user = $_POST["user"];
$pass = $_POST["passw"];


If ((!checkInput($user, $MAXUSERLEN)) || (!checkInput($pass, $MAXPASSLEN))){
	exit("user name or password invalid");
}
$DTNow = date("Y-m-d H:i:s");
echo "User $user writes on $DTNow:<br>";

//call database connect function with parameters set in dbConfig.php
$DBConnection = dbConnect($DatabaseAddress,$DatabasePort,$DatabaseName,$DatabaseUser,$DatabasePass);

$UserQResult = dbQuery($DBConnection, 'SELECT * FROM Users');
//$row = mysqli_fetch_array($UserQResult, MYSQLI_ASSOC); 
$userValid = false;
while($row = mysqli_fetch_array($UserQResult)){
	if ($user == $row['userName']){
		if ($pass == $row['password']){
			$userValid = true;
		}
	}		
}
if ($userValid)
	echo "Username is valid<br>";

?>
<?php
$string = preg_replace("/\r/\n", "<br>", $_POST["bentry"]);
echo $string;

?>

</body>
</html>