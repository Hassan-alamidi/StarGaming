<?php
	$config = parse_ini_file('../../config.ini');
	$dbconnect=mysqli_connect($config['dburl'],$config['username'],$config['password'],$config['dbname']);
	$connect= new mysqli($config['dburl'],$config['username'],$config['password'],$config['dbname']);
	$verify = $config['recaptcha'];
	$adminEmail = $config['Email'];
?>