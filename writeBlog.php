<html>
<body>
<?php
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
	
$MAXUSERLEN = 15;
$MAXPASSLEN = 30;
$user = $_POST["user"];
$pass = $_POST["passw"];


If ((!checkInput($user, $MAXUSERLEN)) || (!checkInput($pass, $MAXPASSLEN))){
	exit("user name or password invalid");
}
$DTNow = date("Y-m-d H:i:s");
echo "User $user writes on $DTNow:<br>";
?>
<?php
$string = preg_replace("/\r/\n", "<br>", $_POST["bentry"]);
echo $string;

?>

</body>
</html>