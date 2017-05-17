<?php
include("dbconnect.php");

class DBsearch extends DBConnect{
	private $data;
	private $dataList;
	private $sound;
	private $searchSound;
	private $allResults;
	private $resultCount;
	private $resultsArray;
	private $PDOConnect;
	private $dbConnect;
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
		$this->connectionSetup();
		$this->PDOConnect = $this->getConnection();

	}

	//begin search is used to search for results in the intended manner
	public function Begin_search(){
		if(strlen($this->data) > 2){
//			try{
//				$this->PDOConnect = new PDO("mysql:host=127.0.0.1; dbname=stargaming","root","");
//				$this->PDOConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//			}catch(PDOException $e){
//				echo $e->getMessage();
//				die();
//			}
			//check for connection error
			
			$this->FullSearch($this->data);
			$this->PostSoundsLike($this->searchSound);

			if(count($this->dataList) > 1){
				foreach ($this->dataList as $value) {
					$tempVal = metaphone($value);
					$tempVal = '%'.$tempVal.'%';
					$this->FullSearch($value);
					$this->PostSoundsLike($tempVal);
				}
			}

			return json_encode($this->allResults);
		}else{
			echo "A valid search must contain 3 or more letters";
		}
	}
	
	//fullsearch searches for records in the database for anything similar to keywords or the name
	//this function maybe redundant as postSoundsLike would more than likely get all of the same results, so I will have to test this out.
	function FullSearch($val){
		
		$sql = "SELECT PGID, PGName, PGUrl, PGImgUrl FROM SearchPG WHERE PGName LIKE :post OR PGKeywords LIKE :post";
		$query =$this->PDOConnect->prepare($sql);
		$query->execute(array('post'=>$val));
		$searchResult = $query->fetchAll(PDO::FETCH_ASSOC);
		$this->CompileResults($searchResult);
	}

	//sounds like searches the database for records that sound similar to the value passed in
	function PostSoundsLike($val){
		$sql = "SELECT SearchPG.PGID, SearchPG.PGName, SearchPG.PGUrl, SearchPG.PGImgUrl FROM metaphonetext JOIN SearchPG ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.NameSound LIKE :post OR metaphonetext.KeywordSound LIKE :post ";
		$query =$this->PDOConnect->prepare($sql);
		$query->execute(array('post'=>$val));
		$searchResult = $query->fetchAll(PDO::FETCH_ASSOC);
		$this->CompileResults($searchResult);
	}


	//the below function compiles all the results from each individual search and stores them in an array
	function CompileResults($searchResult){
		
		foreach ($searchResult as $key => $value) {
			# code...
			if(!in_array($value['PGID'], $this->resultsArray)){						
					Array_Push($this->resultsArray, $value['PGID']);
				$this->allResults[$this->resultCount] = array();
				$this->allResults[$this->resultCount]['id'] = $value['PGID'];
				$this->allResults[$this->resultCount]['name'] = $value['PGName'];
				$this->allResults[$this->resultCount]['url'] = $value['PGUrl'];
				$this->allResults[$this->resultCount]['imgUrl'] = $value['PGImgUrl'];
				$this->resultCount++;
			}
		}
	}
	

}
?>