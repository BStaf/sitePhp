
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
	if (empty($string)){return false;}
	//check if string is too long
	if (strlen($string) > $MaxLen){return false;}
	//check for valid characters	
	else if(!preg_match('/^[A-Za-z0-9_~\-!@#\$%\^&\*]+$/',$string)){return false;}
	else {return true;}
}

class blogEntryDataObj{
	public $title = null;
	public $user = null;
	public $cDTime = null;
	public $data = null;
}

class dbBlog {
	private $DBConnect = null;
	public $blogDataAr = array();
	
	public function __construct() {
		//$blogEntryData = new blogEntryDataObj();
	}
	
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
	function checkBlogLogin($bUser, $bPass){
		$UserQResult = $this->dbQuery('SELECT * FROM Users'); 
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
	
	function writeBlog($UserName,$title,$body){
		
		//$Query = "INSERT INTO blogData (data) VALUES ('".$body."')";
		//$Result = $this->dbQuery($Query);
		//$lastKey = mysqli_insert_id($this->DBConnect);
		//if ($lastKey > 0){
		$Query = "SELECT idUsers from Users where userName = '".$UserName."'";
		echo $Query."\n";
		$Result = $this->dbQuery($Query);
		$UserID = mysqli_fetch_array($Result)['idUsers'];
		
		
		if ($UserID > 0){
			$body = preg_replace("/\r/\n", "<br>", $body);
			$body= addslashes($body);
			$Query = "INSERT INTO blogEntry (blogTitle, timeStampCreated, data, idUsers) VALUES ('".$title."', '".date("Y-m-d H:i:s")."','".$body."','".$UserID."')";
			echo $Query."\n";
			$Result = $this->dbQuery($Query);
			return true;
		}
		return false;
	}
	function getAllBlogData(){
		$dataPresent = false;
		$Query = 	"Select blogEntry.blogTitle, blogEntry.timeStampCreated, blogEntry.data, Users.fullName
					from blogEntry
					INNER JOIN Users on Users.idUsers = blogEntry.idUsers";
		//$Query = 	"Select blogEntry.blogTitle, blogEntry.timeStampCreated from blogEntry";
		$Result = $this->dbQuery($Query);
		while($row = mysqli_fetch_array($Result)){
			$blogObj = new blogEntryDataObj();
			$blogObj->title = $row['blogTitle'];
			$blogObj->user = $row['fullName'];
			$blogObj->cDTime = $row['timeStampCreated'];
			$blogObj->data = $row['data'];
			$this->blogDataAr[] = $blogObj;
			$dataPresent = true;
			//echo $blogObj->title."<br>";
			//echo $this->blogDataAr[0]->title."<br>";
			/*echo 	$row['fullName']." writes:<br>
					On: ".$row['timeStampCreated']."<br>
					title: ".$row['blogTitle']."<br>".$row['data']."<br>";*/
		}
		return $dataPresent;
	}				
		
}
?>