
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
	public function checkBlogLogin($bUser, $bPass){
		$UserQResult = $this->dbQuery('SELECT * FROM Users'); 
		//$userValid = false;
		while($row = mysqli_fetch_array($UserQResult)){
			if ($bUser == $row['userName']){
				if ($bPass == $row['password']){
					if ($row['idUsers'])//check that id is not null, it shouldn't be
						return $row['idUsers'];
					else
						return null;
				}
			}		
		}
		return -1;
	}
	
	public function writeBlog($UserName,$title,$body){
		
		//$Query = "INSERT INTO blogData (data) VALUES ('".$body."')";
		//$Result = $this->dbQuery($Query);
		//$lastKey = mysqli_insert_id($this->DBConnect);
		//if ($lastKey > 0){
		$Query = "SELECT idUsers from Users where userName = '".$UserName."'";
		//echo $Query."\n";
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
	//check database to see if the image name already exists
	//returns true if name does exist
	private function checkIfExistingImage($imageName){
		$Query = "SELECT * from PicRef where PicRef.picName = '".$imageName."'";// where userName = '".$UserName."'";
		//echo $Query;
		$Result = $this->dbQuery($Query);
		//echo mysql_num_rows($Result);
		//while($row = mysqli_fetch_array($Result))
		//	echo $row['picName'];
		if (mysqli_num_rows($Result) > 0)
			return true;
		return false;
	
	}
	
	public function saveImages($imgIDNameAr, $dirPath){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		foreach ($imgIDNameAr as $imgIDName) {
			if (isset($_FILES[$imgIDName])){
				$temp = explode(".", $_FILES[$imgIDName]["name"]);
				$extension = end($temp);
				if ((	($_FILES[$imgIDName]["type"] == "image/gif")
				   || ($_FILES[$imgIDName]["type"] == "image/jpeg")
				   || ($_FILES[$imgIDName]["type"] == "image/jpg")
				   || ($_FILES[$imgIDName]["type"] == "image/pjpeg")
				   || ($_FILES[$imgIDName]["type"] == "image/x-png")
				   || ($_FILES[$imgIDName]["type"] == "image/png"))
						//&& ($_FILES["file"]["size"] < 20000)
				   && in_array($extension, $allowedExts)){
					//echo $imgIDName." is acceptable!\n";
					$imgName = $_FILES[$imgIDName]["name"];
					if (!$this->checkIfExistingImage($imgName)){
						move_uploaded_file($_FILES[$imgIDName]["tmp_name"],
							$dirPath . $_FILES[$imgIDName]["name"]);
						$Query = "INSERT INTO PicRef (picName, idPicType) VALUES ('".$imgName."',1)";
						$Result = $this->dbQuery($Query);
						echo $imgName." added\n";
					}
					else echo "Duplicate Image Found<br>\n";
					//echo "Stored in: " . "upload/" . $_FILES[$imgIDName]["name"];
				}
				else echo $imgIDName." is not acceptable!<br>\n";
			}
			else echo "Null image input from ".$imgIDName."<br>\n";
		}
	}
	public function getAllBlogData(){
		$dataPresent = false;
		//grab all of the title, timestamp, blogger name and entry data
		//this may need to change once I have many entries. Currently I have 1.
		$Query = 	"Select blogEntry.blogTitle, blogEntry.timeStampCreated, blogEntry.data, Users.fullName
					from blogEntry
					INNER JOIN Users on Users.idUsers = blogEntry.idUsers";
		$Result = $this->dbQuery($Query);
		//cycle through all entries
		while($row = mysqli_fetch_array($Result)){
			$blogObj = new blogEntryDataObj();
			$blogObj->title = $row['blogTitle'];
			$blogObj->user = $row['fullName'];
			$blogObj->cDTime = $row['timeStampCreated'];
			//the data field holds the html that appears on this entry. We need to format this properly
			//When using the blog editor, you can enter <pic = [imagename]> [caption] </pic>
			//the logic below will look for that and replace it with a centered picture and caption below
			//I may move this part to a different area as it is very specific to my page and I wanted these
			//functions to be more general
			$dataStr = $row['data'];
			//$formatHandler = 0;
			while (true){
				if (!$subStrLoc = strpos($dataStr,"<pic="))
					break;
				//switch $formatHandler{
				//	case 0://found "<pic" start picture format
						
						$tmpStr2 = substr($dataStr,$subStrLoc+5);						
						$dataStr = substr($dataStr,0,(int)$subStrLoc);
						if (!$subStrLoc = strpos($tmpStr2,">"))
							break;
						//add line to display picture
						$dataStr = $dataStr . "\n<div id='picItem'><center>\n<a href='Pic_Uploads/".substr($tmpStr2,0,(int)$subStrLoc)."'><img src='Pic_Uploads/".substr($tmpStr2,0,(int)$subStrLoc)."'></a>\n";
						//add comment linewe will look for the end of the <pic> statement which is </pic>
						$tmpStr2 = substr($tmpStr2,$subStrLoc+1);
						if (!$subStrLoc = strpos($tmpStr2,"</pic>"))
							break;
						$dataStr = $dataStr . substr($tmpStr2,0,(int)$subStrLoc)."\n</div>\n";
						$dataStr = $dataStr . substr($tmpStr2,$subStrLoc+6);
			
			}
			$blogObj->data = $dataStr;
			
			
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