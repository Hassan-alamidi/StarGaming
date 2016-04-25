<!DOCTYPE html>
<html>
<head>
<title>test</title>
</head>
<body>
<?php echo $_POST['email'];?><br/>
<?php echo $_POST['text'];?><br/>
<?php echo $_POST['Subject'];?><br/>
<?php echo $_POST['comment'];?><br/>
<?php

        $email;$text;$comment;$Subject;$captcha;$text2;$message;
		$admin_email = "support@star-gaming.co.uk";
        if(isset($_POST['email']) && !empty($_POST['email'])){
          $email=$_POST['email'];
		  echo '<h2>email entered</h2>';
        }else{
			echo '<h2>email not entered</h2>';
		}
		if(isset($_POST['text']) && !empty($_POST['text'])){
			$text=$_POST['text'];
			echo '<h2>name entered</h2>';
		}else{
			echo '<h2>name not entered</h2>';
		}
		if(isset($_POST['Subject']) && !empty($_POST['Subject'])){
			$Subject=$_POST['Subject'];
			echo '<h2>subject entered</h2>';
		}else{
			echo '<h2>subject not entered</h2>';
		}
		if(isset($_POST['comment']) && !empty($_POST['comment'])){
          $comment=$_POST['comment'];
		  echo '<h2>comment entered</h2>';
        }else{
			echo '<h2>comment not entered</h2>'
		}
		if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
		if(!empty($_POST['name'])){
			echo '<h2>testing.</h2>';
		}
		else{
			echo '<h2>text2 not entered</h2>'
		}
        if(!$captcha){
          echo '<h2>Please check the the captcha form.</h2>';
          exit;
        }
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdpqQgTAAAAAMMwMVnx6d5mNYpUh5qsIxmrSwU4&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        if($response.success==false)
        {
          echo '<h2>You are spammer ! Get the @$%K out</h2>';
        }else
        {
			$message = "From:" . " " . $email . " " . "Name:" . " " $text . " ". "User Comment:" . " " . $comment; 
			mail($admin_email, $Subject, $message);
          echo '<h2>Thanks for contacting us we will get back to you as soon as possible.</h2>';
        }
?>

</body>
</html>