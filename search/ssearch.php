<!DOCTYPE html>
<!-- to do list
web search optimization
fix scaling issues
try different drop down menus because the one in use is not very good
optimize images for website
look for errors
 -->
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 

 <title>The Latest Gaming News</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" >
	<meta name="keywords" content="Gaming-News, Game, Video-Games, PC-Gaming, Xbox-One, Playstation-4, E3, Game-Reviews, news, reviews, video-game-reviews, video-game-news">
	<meta name="description" content="Get the latest gaming news here">
	<link rel="shortcut icon" href="../images/icon2.ico">
	<link rel="stylesheet" type="text/css" href="../Sub_pages/Subpages_files/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/styleNewsList.css">
	<link rel="stylesheet" type="text/css" href="../css/searchtrans.css">
 </head>
<body >
<!-- page wrapper -->
<div class="container-fluid">  
  <div class="row"> <!-- add row to remove container-fluid padding -->
	<div class="heightNav">
		<!--<div class="navbar-brand" id="logopos">
           <img src="images/GWSecurityLogo.jpg" alt="" id="logo">
        </div>-->

		<div class="navbar-static-top heightNav" id="banner">
			<div id="menuwrap">
			<div class="container-fluid ">
				
				<button class="navbar-toggle" id="menu" data-toggle="collapse" data-target=".navHeaderCollapse">
					Menu
				</button>
				<div class="collapse navbar-collapse navHeaderCollapse" >
					<ul class="nav navbar-nav navbar-right" id="navtoggle">
						<li class="list2" id="menutab"><a data-toggle="collapse" data-target=".navHeaderCollapse">Menu</a></li>
						<li class="list2"><a href="../index.html">Home</a></li>
						<li class="list2"><a href="../About.html">About</a></li>
						<li class="list2"><a href="../Reviews.html">Reviews</a></li>
						<li class="list2"><a href="../NewsList.html">News</a></li>
						<li class="list2"><a href="../ContactUs.php">Contact</a></li>
					</ul>
				</div>
				<!--<form name="searchbar" id="searchbar" method="POST" action="Search.php">
					<input name="usersearch" type="text" size="15" maxlength="50" />
					<input name="Submit" type="Submit" value="&#128269;" />
				</form>-->
				<form class="search-container" id="searchbar"  method="POST" onclick="show()" action="Search.php">
					<input id="search-box" type="text" tabindex="0" class="search-box" name="search-box" />
					<label for="search-box"><span class="search-icon">&#128269;</span></label>
					<input type="submit" class="hide" tabindex="1" id="search-submit" />
				</form>
			</div>
			</div>
		</div>
	</div>
	</div>
		<div class = "row" id="headder">
			<img src="../images/temp.jpg" id="img1pos"  alt="headder image"/>
			<div class="container" id="textcont">
				</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-9">
			<?php
				//include connection file
				include("dbconnect.php");
				
				//check for connection error
				if($connect->connect_errno){
					printf("connection failed, please try again and if this error occurs again please submit this bug through the contact us page", $connect->connect_error);
					exit();
				}
				
				//set a counter, check string length of user input and create array
				$count = 0;
				$lenght = strlen($_POST['search-box']);
				$resultArray=array();
				//if user entered more than 3 letters then continue else let the user know they must enter more than 3 letters
				if($lenght > 2){
					
					//set variables for user input
					$searchtext= '%'.$_POST['search-box'].'%';
					$searchbit=explode(" ", $_POST['search-box']);
					$words = count($searchbit);
					$sound= metaphone($_POST['search-box']);
					$searchsound = '%'.$sound.'%';
					
					//connect to database and get values related to user search based on what matches PGName
					//need to get dates when I learn how to sort them
					$sqlname= $connect->prepare("SELECT PGID, PGName, PGUrl, PGImgUrl FROM SearchPG WHERE PGName LIKE ? ");
					//bind users value to the prepared statement
					$sqlname->bind_param("s", $searchtext);
					//execute the statement
					$sqlname->execute();
					//store the result
					$sqlname->store_result();
					
					//check the number of rows then display them note: this is only for testing purposes 
					
	
					//$NameResult = $sqlName->get_result();
					//var_dump($NameResult); exit;
					
					//connect to database and get values related to user search based on what matches PGKeywords
					//need to get dates when I learn how to sort them
					$sqltext= $connect->prepare("SELECT PGID, PGName, PGUrl, PGImgUrl FROM SearchPG WHERE PGKeywords LIKE ? ");
					//bind users value to the prepared statement
					$sqltext->bind_param("s", $searchtext);
					//execute the statement
					$sqltext->execute();
					//store the result
					$sqltext->store_result();
					//check the number of rows then display them note: this is only for testing purposes 
					

					//$TextResult = $sqltext->get_result();
					//printf($TextResult->error);
					$sqlsound= $connect->prepare("SELECT metaphonetext.PGID, metaphonetext.NameSound, metaphonetext.KeywordSound, SearchPG.PGID, SearchPG.PGName, SearchPG.PGUrl, SearchPG.PGImgUrl FROM metaphonetext JOIN SearchPG ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.NameSound LIKE ? ");
					$sqlsound->bind_param("s", $searchsound);
					$sqlsound->execute();
					$sqlsound->store_result();
					
					
					//$soundResult = $sqlsound->get_result();
				
					if(false === $sqlsound && false===$sqltext && false===$sqlname){
						echo "something has gone wrong qry failed one of the values could not be stored, please try again and if this error occurs again please submit this bug through the contact us page".htmlspecialchars($sqlsound->error).htmlspecialchars($sqltext->error).htmlspecialchars($sqlname->error);
					}else{
						if($sqlname->num_rows > 0 || $sqltext->num_rows > 0){
							if($sqlname->num_rows > 0 ){
								$sqlname->bind_result($id, $name, $url, $imgurl);
								while($rs = $sqlname->fetch()){
									
									if(!in_array($id, $resultArray)){
										Array_Push($resultArray, $id);
									?>
									<div class="row resultcontent">
										<a href="<?php echo $url;?>">
											<div class="col-sm-8 searchRsltCont">
												<img src="<?php echo $imgurl;?>" class="searchRsltimg" alt="search result image" />
												<div class="contshading">
												</div>
											</div>
											<div class="col-sm-4 searchRslttxt">
												<h1><?php echo $name;?></h1>
											</div>
										</a>
									</div>
									<?php
									$count++;
									}
								}
							}
							if($count<10){
								
								if($words > 1){
								foreach($searchbit as $value){
									$temp = '%'.$value.'%';
									$sqlvalue= $connect->prepare("SELECT PGID, PGName, PGUrl, PGImgUrl FROM SearchPG WHERE PGName LIKE ? OR PGKeywords LIKE ? ");
									if ( false===$sqlvalue ) {
										die('connect failed, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlvalue->error));
									}
									$sqlvalue->bind_param("ss", $temp, $temp);
									if ( false===$sqlvalue ) {
										die('bind failed, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlvalue->error));
									}
									$sqlvalue->execute();
									if ( false===$sqlvaue ) {
										die('execute() failed, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlvalue->error));
									}
									$sqlvalue->store_result();
									if ( false===$sqlvaue ) {
										die('Failed to store your search, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlvalue->error));
									}
									//$ValueResult = $sqlvalue->get_result();
									
									if($sqlvalue->num_rows > 0){
										$sqlvalue->bind_result($id, $name, $url, $imgurl);
										
										while($rs = $sqlvalue->fetch()){
											if(!in_array($id, $resultArray)){
												Array_Push($resultArray, $id);
											?>
											<div class="row resultcontent">
												<a href="<?php echo $url;?>">
													<div class="col-sm-8 searchRsltCont">
														<img src="<?php echo $imgurl;?>" class="searchRsltimg" alt="search result image" />
														<div class="contshading">
														</div>
													</div>
													<div class="col-sm-4 searchRslttxt">
														<h1><?php echo $name;?></h1>
													</div>
												</a>
											</div>
											<?php
											$count++;
											}
										}
									}
								}
								}
								$sqltext->bind_result($id, $name, $url, $imgurl);
								while($rs = $sqltext->fetch()){
									if(!in_array($id, $resultArray)){
										Array_Push($resultArray, $id);
									?>
									<div class="row resultcontent">
										<a href="<?php echo $url;?>">
											<div class="col-sm-8 searchRsltCont">
												<img src="<?php echo $imgurl;?>" class="searchRsltimg" alt="search result image" />
												<div class="contshading">
												</div>
											</div>
											<div class="col-sm-4 searchRslttxt">
												<h1><?php echo $name;?></h1>
											</div>
										</a>
									</div>
									<?php
									$count++;
									}
								}
						
						
							}
						}else if($sqlsound->num_rows > 0){
							$sqlsound->bind_result($MID, $NameSound, $KeywordSound, $PGID, $PGName, $PGUrl, $PGImgUrl);
							echo $NameSound;
							while($rs = $sqlsound->fetch()){
								if(!in_array($PGID, $resultArray)){
										Array_Push($resultArray, $PGID);
								?>
								<div class="row resultcontent">
									<a href="<?php echo $PGUrl;?>">
										<div class="col-sm-8 searchRsltCont">
											<img src="<?php echo $PGImgUrl;?>" class="searchRsltimg" alt="search result image" />
											<div class="contshading">
											</div>
										</div>
										<div class="col-sm-4 searchRslttxt">
											<h1><?php echo $PGName;?></h1>
										</div>
									</a>
								</div>
								<?php
								$count++;
								}
							}
						}else{
							foreach($searchbit as $value){
							$temp = metaphone($value);
							$metatemp = '%'.$temp.'%';
							
							$sqlsound2=$connect->prepare("SELECT metaphonetext.PGID, metaphonetext.NameSound, metaphonetext.KeywordSound, SearchPG.PGID, SearchPG.PGName, SearchPG.PGUrl, SearchPG.PGImgUrl FROM metaphonetext JOIN SearchPG ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.NameSound LIKE ? OR metaphonetext.KeywordSound LIKE ? ");
							if ( false===$sqlsound2 ) {
										die('connect failed, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlsound2->error));
									}
							$sqlsound2->bind_param("ss", $metatemp, $metatemp);
							if ( false===$sqlsound2 ) {
										die('bind failed, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlsound2->error));
									}
							$sqlsound2->execute();
							if ( false===$sqlsound2 ) {
										die('connect failed, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlsound2->error));
									}
							$sqlsound2->store_result();
							if ( false===$sqlsound2 ) {
										die('Failed to store your search, please try again and if this error occurs again please submit this bug through the contact us page: ' . htmlspecialchars($sqlvalue->error));
									}
							
		
							//$ValueSoundResult = $sqlsound->get_result();
						
							//$sqlsoundkey="SELECT metaphonetext.*, SearchPG.* FROM metaphonetext JOIN PGKeywords ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.KeywordSound LIKE ? ";
						
							if($sqlsound2->num_rows > 0){
								
								$sqlsound2->bind_result($MID, $NameSound, $KeywordSound, $PGID, $PGName, $PGUrl, $PGImgUrl);
								while($rs = $sqlsound2->fetch()){
									if(!in_array($PGID, $resultArray)){
										Array_Push($resultArray, $PGID);
									?>
									<div class="row resultcontent">
										<a href="<?php echo $PGUrl;?>">
											<div class="col-sm-8 searchRsltCont">
												<img src="<?php echo $PGImgUrl;?>" class="searchRsltimg" alt="search result image" />
												<div class="contshading">
												</div>
											</div>
											<div class="col-sm-4 searchRslttxt">
												<h1><?php echo $PGName;?></h1>
											</div>
										</a>
									</div>
									<?php
									$count++;
									}
								}
								//everything below needs to be changed
							}/*else if(mysqli_num_rows($qrysoundkey)>0){
							$rskey=mysqli_fetch_assoc($qrysoundkey);
							do{
							?>
								<div class="row resultcontent">
									<a href="<?php echo $rskey['PGUrl'];?>">
										<div class="col-sm-8 searchRsltCont">
											<img src="<?php echo $rskey['PGImgUrl'];?>" class="searchRsltimg" alt="search result image" />
											<div class="contshading">
											</div>
										</div>
										<div class="col-sm-4 searchRslttxt">
											<h1><?php echo $rskey['PGName'];?></h1>
										</div>
									</a>
								</div>
							<?php
							} while($rs=mysqli_fetch_assoc($qrysoundkey));
						}*/else if($sqlsound2 === false /*&& mysqli_num_rows($qrysoundkey)<=0*/){
							?>
							<p>no results found</p>
							<?php
						}else{
							?>
								<p>no more results found</p>
							<?php
						}
					}	
				}
				}
				}else{
					echo "A valid search must contain more than 3 letters";
					
				}
			?>
			</div>
			<div class="col-md-3 hide">
				<img src="../images/Xbox.jpg" class="adverttest" alt="xbox"/>
			</div>
		</div>
		
	</div>
	<div class = "row" id = "contentsplitter">
 
   </div>
	<footer class="footer">
		<div class="container">
			<p class="pull-right">
			<a id="bktotop" href="ssearch.html#"> Back to top </a>
			</p>
			<p id = "footer"> &#10032; Star-Gaming </p>
			<hr/>
				
		</div>
	</footer>
<script src="../bootstrap/js/jquery-1.11.2.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
<script src="../css/temp.js"></script>

</body></html>