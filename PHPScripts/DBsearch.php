<?php
include("dbconnect.php");
class DBsearch{
	private $data;
	private $dataList;
	private $sound;
	private $searchSound;
	private $allResults;
	private $resultCount;
	private $resultsArray;
	//TODO add error checks

	//this is the class constructer used to setup the entire class
	public function __construct($postData){
		$this->data = '%'.$postData.'%';
		$this->dataList = explode(" ", $postData);
		
		$this->sound = metaphone($postData);
		$this->searchSound = '%'.$this->sound.'%';
		$this->allResults = array();
		$this->resultsArray = array();
		$this->resultCount = 0;

	}

	//begin search is used to search for results in the intended manner
	public function Begin_search(){
		if(strlen($this->data) > 2){
		//check for connection error
			global $connect;
		if($connect->connect_errno){
			printf("connection failed, please try again and if this error occurs again please submit this bug through the contact us page", $connect->connect_error);
			exit();
		}
		$this->FullSearch($this->data);
		$this->PostSoundsLike($this->searchSound);

		foreach ($this->dataList as $value) {
			$tempVal = metaphone($value);
			$tempVal = '%'.$tempVal.'%';
			$this->FullSearch($value);
			$this->PostSoundsLike($tempVal);
		}
		return json_encode($this->allResults);
		}else{
			echo "A valid search must contain 3 or more letters";
		}
	}
	
	//fullsearch searches for records in the database for anything similar to keywords or the name
	function FullSearch($val){
		global $connect;
		$searchResult = $connect->prepare("SELECT PGID, PGName, PGUrl, PGImgUrl FROM SearchPG WHERE PGName LIKE ? OR PGKeywords LIKE ?");
		$searchResult->bind_param("ss", $val, $val);
		$searchResult->execute();
		$searchResult->store_result();

		$this->CompileResults($searchResult);
		$searchResult->close();
		
	}

	//sounds like searches the database for records that sound similar to the value passed in
	function PostSoundsLike($val){
		global $connect;
		$searchResult = $connect->prepare("SELECT SearchPG.PGID, SearchPG.PGName, SearchPG.PGUrl, SearchPG.PGImgUrl FROM metaphonetext JOIN SearchPG ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.NameSound LIKE ? OR metaphonetext.KeywordSound LIKE ? ");
		$searchResult->bind_param("ss", $val, $val);
		$searchResult->execute();
		$searchResult->store_result();

		$this->CompileResults($searchResult);
		$searchResult->close();
	}


	//the below function compiles all the results from each individual search and stores them in an array
	function CompileResults($searchResult){

		if($searchResult->num_rows > 0){
			$searchResult->bind_result($id, $name, $url, $imgurl);
			while($rs = $searchResult->fetch()){
				if(!in_array($id, $this->resultsArray)){						
					Array_Push($this->resultsArray, $id);
					$this->allResults[$this->resultCount] = array();
					$this->allResults[$this->resultCount]['id'] = $id;
					$this->allResults[$this->resultCount]['name'] = $name;
					$this->allResults[$this->resultCount]['url'] = $url;
					$this->allResults[$this->resultCount]['imgUrl'] = $imgurl;
					$this->resultCount++;
				}
			}
		}
	}
	

}
?>