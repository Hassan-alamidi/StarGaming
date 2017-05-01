<?php
	$config = parse_ini_file('../.config/config.ini');
	$dbconnect=mysqli_connect($config['dburl'],$config['username'],'',$config['dbname']);
	$connect= new mysqli($config['dburl'],$config['username'],'',$config['dbname']);
	$verify = $config['recaptcha'];
	$adminEmail = $config['Email'];
?>