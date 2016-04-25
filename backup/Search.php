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
				<form class="search-container" id="searchbar"  method="POST" onclick="show()" action="ssearch.php">
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
				include("dbconnect.php");
				$count = 0;
				$searchtext= $_POST['search-box'];
				$searchbit=explode(" ", $_POST['search-box']);
				$searchsound= metaphone($_POST['search-box']);
				$sqlName="SELECT * FROM SearchPG WHERE PGName LIKE '%".mysqli_real_escape_String($dbconnect, $_POST['search-box'])."%'";
				$sqltext="SELECT * FROM SearchPG WHERE PGName LIKE '%".mysqli_real_escape_String($dbconnect, $_POST['search-box'])."%' OR PGKeywords LIKE '%".mysqli_real_escape_String($dbconnect, $_POST['search-box'])."%' ";
				$sqlsound="SELECT metaphonetext.*, SearchPG.* FROM metaphonetext JOIN SearchPG ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.NameSound LIKE '%".mysqli_real_escape_String($dbconnect, $searchsound)."%'";
				$qryname=mysqli_query($dbconnect, $sqlName);
				$qrytext=mysqli_query($dbconnect, $sqltext);
				$qrysound=mysqli_query($dbconnect, $sqlsound);
				if(!$qrysound || !$qrytext || !$qryname){
					echo "something has gone wrong qry failed". mysqli_error();
				}else{
				if(mysqli_num_rows($qryname)>0){
					$rs=mysqli_fetch_assoc($qryname);
					do{
						?>
						<div class="row resultcontent">
							<a href="<?php echo $rs['PGUrl'];?>">
								<div class="col-sm-8 searchRsltCont">
									<img src="<?php echo $rs['PGImgUrl'];?>" class="searchRsltimg" alt="search result image" />
									<div class="contshading">
									</div>
								</div>
								<div class="col-sm-4 searchRslttxt">
									<h1><?php echo "name".$rs['PGName'];?></h1>
								</div>
							</a>
						</div>
						<?php
						$count++;
					} while($rs=mysqli_fetch_assoc($qryname));
				} elseif(mysqli_num_rows($qrytext)>0){
					foreach($searchbit as $value){
						$temp = $value;
						$sqltext="SELECT * FROM SearchPG WHERE PGName LIKE '%".$temp."%' OR PGKeyword LIKE '%".$temp."%' ";
						$qrytext=mysqli_query($dbconnect, $sqltext);
						$rs=mysqli_fetch_assoc($qrytext);
						do{
						?>
							<div class="row resultcontent">
							<a href="<?php echo $rs['PGUrl'];?>">
								<div class="col-sm-8 searchRsltCont">
									<img src="<?php echo $rs['PGImgUrl'];?>" class="searchRsltimg" alt="search result image" />
									<div class="contshading">
									</div>
								</div>
								<div class="col-sm-4 searchRslttxt">
									<h1><?php echo "keywords".$rs['PGName'];?></h1>
								</div>
							</a>
						</div>
						<?php
						$count++;
					} while($rs=mysqli_fetch_assoc($qrytext));
					}
				} elseif(mysqli_num_rows($qrysound)>0){
					$rs=mysqli_fetch_assoc($qrysound);
					do{
						?>
						<div class="row resultcontent">
							<a href="<?php echo $rs['PGUrl'];?>">
								<div class="col-sm-8 searchRsltCont">
									<img src="<?php echo $rs['PGImgUrl'];?>" class="searchRsltimg" alt="search result image" />
									<div class="contshading">
									</div>
								</div>
								<div class="col-sm-4 searchRslttxt">
									<h1><?php echo $rs['PGName'];?></h1>
								</div>
							</a>
						</div>
						<?php
						$count++;
					} while($rs=mysqli_fetch_assoc($qrysound));	
				}else{
					foreach($searchbit as $value){
						$temp = metaphone($value);
						$sqlsound="SELECT metaphonetext.*, SearchPG.* FROM metaphonetext JOIN PGName ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.NameSound LIKE '%".$temp."%'";
						$sqlsoundkey="SELECT metaphonetext.*, SearchPG.* FROM metaphonetext JOIN PGKeywords ON metaphonetext.PGID=SearchPG.PGID WHERE metaphonetext.KeywordSound LIKE '%".$temp."%'";
						$qrysound=mysqli_query($dbconnect, $sqlsound);
						$qrysoundkey=mysqli_query($dbconnect, $sqlsoundkey);
						if(mysqli_num_rows($qrysound)>0){
							$rs=mysqli_fetch_assoc($qrysound);
							do{
							?>
								<div class="row resultcontent">
									<a href="<?php echo $rs['PGUrl'];?>">
										<div class="col-sm-8 searchRsltCont">
											<img src="<?php echo $rs['PGImgUrl'];?>" class="searchRsltimg" alt="search result image" />
											<div class="contshading">
											</div>
										</div>
										<div class="col-sm-4 searchRslttxt">
											<h1><?php echo $rs['PGName'];?></h1>
										</div>
									</a>
								</div>
							<?php
							} while($rs=mysqli_fetch_assoc($qrysound));
						}else if(mysqli_num_rows($qrysoundkey)>0){
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
						}else if(mysqli_num_rows($qrysound)<=0 && mysqli_num_rows($qrysoundkey)<=0){
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