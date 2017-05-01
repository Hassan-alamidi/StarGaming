<!DOCTYPE html>
<!-- to do list
web search optimization
fix scaling issues
try different drop down menus because the one in use is not very good
optimize images for website
look for errors
 -->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Contact US </title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<meta name="viewport" content="width=device-width, initial-scale=1" >
	<meta name="keywords" content="Contact-Us, Gaming-News, Game, Video-Games, PC-Gaming, Xbox-One, Playstation-4, E3, Game-Reviews, news, reviews, video-game-reviews, video-game-news">
	<meta name="description" content="Contact Us about any questions you may have">
	<link rel="shortcut icon" href="images/icon2.ico">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styleContactUs.css">
	<link rel="stylesheet" type="text/css" href="css/searchtrans.css">
 </head>
<body >
<!-- page wrapper -->
<div class="container-fluid">  
  <div class="row"> <!-- add row to remove container-fluid padding -->
	<div class="heightNav">

		<div class="navbar-static-top heightNav" id="banner">
	 
			<div class="container-fluid">
         
				<button class="navbar-toggle" id="menu" data-toggle="collapse" data-target=".navHeaderCollapse">
					Menu
				</button>
				<div class="collapse navbar-collapse navHeaderCollapse" >
					<ul class="nav navbar-nav navbar-right" id="navtoggle">
						<li class="list2" id="menutab"><a data-toggle="collapse" data-target=".navHeaderCollapse">Menu</a></li>
						<li class="list2"><a href="index.html">Home</a></li>
						<li class="list2"><a href="About.html">About</a></li>
						<li class="list2"><a href="Reviews.html">Reviews</a></li>
						<li class="list2"><a href="NewsList.html">News</a></li>
						<li class="list2"><a href="ContactUs.php">Contact</a></li>
					</ul>
				</div>
				<form class="search-container" id="searchbar"  method="POST" onclick="show()" action="search/Search.php">
					<input id="search-box" type="text" tabindex="0" class="search-box" name="search-box" />
					<label for="search-box"><span class="search-icon">&#128269;</span></label>
					<input type="submit" class="hide" tabindex="1" id="search-submit" />
				</form>
			</div>
		</div>
	</div>
	</div>
		<div class = "row" id="headder">
			<img src="images/temp.png" id="img1pos" alt="game mashup " scaleContent="true"/>
			<div class="container" id="textcont">
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 maincontainer">
				<div class="container txtmain">
					<h1> Contact Us</h1>
					<p>If you would like to contact us for any reason, you can contact us on twitter (link below) or by filling in the form at the bottom of this page.</p>
					<br/>
					<p>Twitter Profile:</p> <a href="https://twitter.com/_Star_Gaming" ><p>https://twitter.com/_Star_Gaming</p></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 maincontainer">
			</div>
			<div class="col-md-4 maincontainer">
				 <form id="comment_form" action="contactForm.php" method="POST">
					<input type="name" name="name" class="bx" size="40"><br/>
					<input type="text" name="text" placeholder="Name" class="txtboxes" size="40"><br/>
					<input type="email" name="email" placeholder="Type your email" class="txtboxes" size="40"><br/>
					<input type="Subject" name="Subject" placeholder="Subject" class="txtboxes" size="40"><br/>
					<textarea name="comment" rows="8" class="txtboxes" cols="42"></textarea><br/>
					<div class="g-recaptcha btns" data-sitekey="6LdpqQgTAAAAAG8d57RTmnC-wzwRBRJuGx0ir8jT"></div>
					<input type="submit" class="btns" name="submit" value="Send"><br><br>
				</form>
				
			</div>
			<div class="col-md-4 maincontainer">
			</div>
		</div>
	</div>
	
	<div class = "row" id = "contentsplitter">
 
   </div>
	<footer class="footer">
		<div class="container">
			<p class="pull-right">
			<a id="bktotop" href="About.html#"> Back to top </a>
			</p>
			<p id = "footer"> &#10032; Star-Gaming </p>
			<hr/>
		
			
		</div>
	</footer>
<script src="bootstrap/js/jquery-1.11.2.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="css/temp.js"></script>

</body></html>