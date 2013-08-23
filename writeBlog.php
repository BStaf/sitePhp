
<?php
//include php script with database login info
include 'dbConfig.php'; 

//returns true if input is valid
//input string to be tested and max length of that string
//this function does allow alphanumeric, and some special characters, 
//but does not allow "; ( ) "
$MAXUSERLEN = 15;
$MAXPASSLEN = 30;
function checkInput($string, $MaxLen){
	//ctype_alnum($user)
	//check for empty string
	if (empty($string)){echo "empty str"; return false;}
	//check if string is too long
	if (strlen($string) > $MaxLen){echo "max length"; return false;}
	//check for valid characters	
	else if(!preg_match('/^[A-Za-z0-9_~\-!@#\$%\^&\*]+$/',$string)){echo "invalid Character"; return false;}
	else {echo "input OKr";return true;}
}

class wrtieBlog {
	private $DBConnect = null;
	
	public function __construct() {}
	
	//database connect function
	public function dbConnect($DBAddr,$DBPort,$DBName,$DBUser,$DBPass){
		// Connecting, selecting database  
		if (!$this->DBConnect = mysqli_connect($DBAddr,$DBUser,$DBPass,$DBName,$DBPort)) { 
			throw new Exception('Failed to connect to Server' . mysql_error()); 
			return false;
		} 
		return true;
	}
	//querry function
	private function dbQuery(/*$DBConnect, */$Query){
		if (!$result = mysqli_query($this->DBConnect,$Query)) {  
			throw new Exception('Query failed: ' . mysql_error()); 
			return -1;
		} 
		return $result;
	}
	//checks user exists and has the same password.
	//If user exists and is validated, returns user key ID, if not return -1
	function checkBlogLogin(/*$DBConnect,*/ $bUser, $bPass){
		$UserQResult = $this->dbQuery(/*$DBConnect,*/'SELECT * FROM Users'); 
		//$userValid = false;
		while($row = mysqli_fetch_array($UserQResult)){
			if ($bUser == $row['userName']){
				if ($bPass == $row['password']){
					if ($row['idUsers'])//check that id is not null, it shouldn't be
						return $row['idUsers'];
					else
						return -1;
				}
			}		
		}
		return -1;
	}
	
	function writeBlog($UserID,$title,$body){
		$body = preg_replace("/\r/\n", "<br>", $body);
		$Query = "INSERT INTO blogData (data) VALUES ('".$body."')";
		$Result = $this->dbQuery($Query);
		$lastKey = mysqli_insert_id($this->DBConnect);
		if ($lastKey > 0){
			$Query = "INSERT INTO blogEntry (blogTitle, timeStampCreated, idblogData) VALUES ('".$title."', '".date("Y-m-d H:i:s")."',".$lastKey.")";
			$Result = $this->dbQuery($Query);
		}
	}
}
?>