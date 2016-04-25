<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> Email report</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" >
	<link rel="shortcut icon" href="images/icon2.ico">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styleContactUs.css">
</head>
<body>
<div class="container-fluid">  
  <div class="row"> <!-- add row to remove container-fluid padding -->
	<div class="heightNav">
		<!--<div class="navbar-brand" id="logopos">
           <img src="images/GWSecurityLogo.jpg" alt="" id="logo">
        </div>-->

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
			</div>
		</div>
	</div>
	</div>
		<div class="row">
			<div class="col-md-3">
			</div>
			<div class="col-md-6 error">
				
<div id="errorfld">			
<?php
include("dbconnect.php");

if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
}
if($captcha){
if(isset($_POST['submit'])){
$spam = $_POST['name'];
$name = $_POST['text'];
$useremail = $_POST['email'];
$subject = $_POST['Subject'];
$comment = $_POST['comment'];
$message = "From $useremail \n Name $name \n $comment \n Email $useremail";
	if(!empty($spam)){
		echo "something has gone wrong please try again";
	} else{
		if($name){
			if($useremail){
				if($subject){
					if($comment){
						$response=file_get_contents($verify.$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
						if($response.success==false)
							{
								echo 'something has gone wrong please try again';
							}else{
								$result = mail($adminEmail, $subject, $message);
						
								if($result == 1){
									echo "your email has been sent, we will try to respond as soon as possible";
								}else{
									echo "<a href='ContactUs.php'>Something has gone wrong please click here to try again</a>";
								}
							}
					}else{
						echo "<a href='ContactUs.php'>sending failed, comment box empty, click here to return</a>";
					}
			
				}else{
					echo "<a href='ContactUs.php'>sending failed, subject not entered please click here and try again</a>";
				}
			}else{
				echo "<a href='ContactUs.php'>sending failed, your email was not entered please click here and try again</a>";
			}
		}else{
			echo "<a href='ContactUs.php'>sending failed, name not entered please click here and try again</a>";
		}
	}
}
}else{
 echo "<a href='ContactUs.php'>sending failed, Please tick the recaptcha. click this link to return to contact page</a>";
	
}

?>
</div>
			</div>
			<div class="col-md-3">
			</div>
		</div>
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
</body>
</html>