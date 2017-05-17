<!DOCTYPE html>
<html>
<head>
<title> admin </title>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<!--TODO Add upload image feature-->
<form method="post" action="entertext.php">
	<input name="name" placeholder="name" />
	<input name="title" placeholder="title" />
	<input name="description" placeholder="description" />
	<input name="keywords" placeholder="keywords" />
	<input name="url" placeholder="url" />
	<input name="imgurl" placeholder="imgurl" />
	<input name="releasedate" placeholder="release date" />
	<input name="publishdate" placeholder="publish date" />
	<input name="username" placeholder="username">
	<input name="password" type="password" placeholder="password" />
	<div class="g-recaptcha btns" data-sitekey="6LdpqQgTAAAAAG8d57RTmnC-wzwRBRJuGx0ir8jT"></div>
	<input type="submit" name="submit" value="submit" />
</form>
<body>
</html>