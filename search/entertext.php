<?php
	include("../PHPScripts/dbconnect.php");

	class AddRecord extends DBConnect{
		//declare variables
		private $recaptcha;
		private $adminPass;
		private $adminUsername;
		private $articalHeading;
		private $artcialContent;
		private $articalKeywords;
		private $articalUrl;
		private $articalImg;
		private $gameReleaseDate;
		private $articalPublishDate;
		private $nameSound;
		private $keywordSound;
		private $isRecaptchaImplemented;
		private $PDOConnect;
		private $sqlInsert, $sqlLogin, $sqlMaxID, $sqlMeta;

		//create constructer to setup the class
		public function __construct($recaptca,$password,$username,$objName,$objDescription, $objKeyWords, $objUrl, $objImgUrl,$objReleaseDate, $objPublishDate){
			//clean variables of any undesired chars
			$this->sanitizeVariables($password,$username,$objName,$objDescription, $objKeyWords, $objUrl, $objImgUrl,$objReleaseDate, $objPublishDate);
			$this->setupSqlStatements();
			//recaptcha is not functional on local servers so must enable/disable manually
			$this->isRecaptchaImplemented = false;

			//check if recaptcha is implemented if so check if it is null
			//if this fails then just set recaptcha as null and deal with it later
			if($this->isRecaptchaImplemented == true && $this->checkVar($this->recaptcha) === true){
				$this->recaptcha = $recaptcha;
			}else{
				$this->recaptcha = null;
			}

			
		}

		public function beginTransaction(){
			
			if($this->checkVar($this->recaptcha) === false && $this->isRecaptchaImplemented === true ){
				header("Location:../index.html");
			}else if($this->checkVar($this->recaptcha) === true && $this->isRecaptchaImplemented === true ){
				$response=file_get_contents($verify.$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
				if($response.success == false){
					header("Location:../index.html");
				}
			}

			$this->connectionSetup();
			$this->PDOConnect = $this->getConnection();

			if($this->checkAdminCredentials()){
				$this->submitData();
			}


		}

		

		private function submitData(){

			$query = $this->PDOConnect->prepare($this->sqlInsert);
			$query->execute(array('PGName'=>$this->articalHeading, 'PGContent'=>$this->artcialContent, 'PGKeywords'=>$this->articalKeywords, 'PGUrl'=>$this->articalUrl,
									'PGImgUrl'=>$this->articalImg, 'gameReleaseDate'=>$this->gameReleaseDate, 'PGPublishDate'=>$this->articalPublishDate));
			if($query === false){
				die('failed error 6 ' . htmlspecialchars($query->error));	
			}
			//Get maxID from searchPG which should be the new entry
			$getMaxID = $this->PDOConnect->prepare($this->sqlMaxID);
			$getMaxID->execute();
			if($getMaxID === false){
				die('failed error 6 ' . htmlspecialchars($getMaxID->error));	
			}
			$maxID = $getMaxID->fetchColumn();
			
			$queryMeta = $this->PDOConnect->prepare($this->sqlMeta);
			$queryMeta->execute(array('nameSound'=>$this->nameSound, 'keySound'=>$this->keywordSound, 'FKey'=>$maxID));
			if($queryMeta === false){
				die('failed error 6 ' . htmlspecialchars($queryMeta->error));	
			}else{
				echo "worked";
			}
		}

		private function checkAdminCredentials(){
			
			$query = $this->PDOConnect->prepare($this->sqlLogin);
			$query->execute(array('adminName'=>$this->adminUsername, 'adminPassword'=>$this->adminPass));

			if($query === false){
				die('failed error 6 ' . htmlspecialchars($query->error));	
			}

			$searchResults = $query->fetch(PDO::FETCH_ASSOC);
			if($this->adminUsername === $searchResults['test1a'] && $this->adminPass === $searchResults['test2']){
				return true;
			}else{
				return false;
			}
		}

		//these have benn seperated to make code a little cleaner
		private function setupSqlStatements(){
			//this sql statment inserts a new artical/record into the database
			$this->sqlInsert = "INSERT INTO SearchPG (PGName, PGDescription, PGKeywords, PGUrl, PGImgUrl, PGReleaseDate, PGPublishDate) VALUES (:PGName, :PGContent, :PGKeywords, :PGUrl, :PGImgUrl, :gameReleaseDate, :PGPublishDate)";
			//this sql statment checks if the admins credentials exists
			$this->sqlLogin = "SELECT test1a, test2 FROM testDB WHERE test1a= :adminName AND test2= :adminPassword";
			//this sql statement checks for the record with the largest id
			$this->sqlMaxID = "SELECT MAX(PGID) FROM SearchPG";
			//this sql stament inserts a record into the table metaphonetext and uses the max id as a forign key
			$this->sqlMeta = "INSERT INTO metaphonetext (NameSound, KeywordSound, PGID) VALUES (:nameSound, :keySound, :FKey)";
		}

		private function sanitizeVariables($password,$username,$objName,$objDescription, $objKeyWords, $objUrl, $objImgUrl,$objReleaseDate, $objPublishDate){

			//clean the admin password and username and convert to sha1. NOTE: must implement better hashing
			$this->adminPass = sha1($this->cleanVar($password));
			$this->adminUsername = sha1($this->cleanVar($username));
			//cleanvariables to enusure no user is attempting to submit code or trick the server in anyway. 
			//NOTE PDO already deals with this but this is just added mesures of precautions
			$this->articalHeading = $this->cleanVar($objName);
			$this->artcialContent = $this->cleanVar($objDescription);
			$this->articalKeywords = stripcslashes($objKeyWords);
			$this->articalKeywords= htmlspecialchars($this->articalKeywords);
			$this->articalUrl = htmlspecialchars($objUrl);
			$this->articalImg = htmlspecialchars($objImgUrl);
			$this->gameReleaseDate = htmlspecialchars($objReleaseDate);
			$this->articalPublishDate= htmlspecialchars($objPublishDate);
			$this->nameSound=metaphone($this->articalHeading);
			$this->keywordSound=metaphone($this->articalKeywords);


		}

		private function checkVar($var){
			if(isset($var) && !empty($var)){
				return true;
			}
			return false;
		}

		private function cleanVar($var){
			$var = trim($var);
			$var = stripcslashes($var);
			$var = htmlspecialchars($var);
			return $var;
		}
	}

	$record = new AddRecord($_POST['g-recaptcha-response'], $_POST['password'], $_POST['username'],$_POST['name'], $_POST['description'], $_POST['keywords'], $_POST['url'], $_POST['imgurl'], $_POST['releasedate'], $_POST['publishdate']);
	$record->beginTransaction();

?>