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
					require('../PHPScripts/DBsearch.php');
					require('../PHPScripts/ConstructPage.php');
					if($_SERVER["REQUEST_METHOD"] == "POST"){

						$search = new DBsearch(htmlspecialchars($_POST['search-box']));
						$results = $search->Begin_search();
						$pgConstruct = new ConstructPage();
						$pgConstruct->ConstructSearchResults($results);
					}else{
						echo "Something has gone wrong please try again";
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

	</body>
</html>