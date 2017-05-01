<?php
class ConstructPage{

	//TODO limit the amount of results per page and store them for later
	public function ConstructSearchResults($encodedVal){
		$val = array();
		$val = json_decode($encodedVal, true);
		for ($i = 0; $i < count($val); $i++) { 
			$name = $val[$i]['name'];
			$url = $val[$i]['url'];
			$imgUrl = $val[$i]['imgUrl'];
			?>
				<div class="row resultcontent">
					<a href="<?php echo $url;?>">
						<div class="col-sm-8 searchRsltCont">
							<img src="<?php echo $imgUrl;?>" class="searchRsltimg" alt="search result image" />
							<div class="contshading">
							</div>
						</div>
						<div class="col-sm-4 searchRslttxt">
							<h1><?php echo $name;?></h1>
						</div>
					</a>
				</div>
			<?php
		}
	}
}
?>