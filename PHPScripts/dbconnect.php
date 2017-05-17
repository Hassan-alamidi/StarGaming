<?php
	class DBConnect{
	
	//$dbconnect=mysqli_connect($config['dburl'],$config['username'],'',$config['dbname']);
	//$connect= new mysqli($config['dburl'],$config['username'],'',$config['dbname']);
	//$PDOConnect = new PDO("mysql:host=".$config['dburl'] ."; dbname=".$config['dbname'],$config['username'],"");
	private $config;
	private $verify;
	private $adminEmail;
	private $PDOConnection;
	
	public function connectionSetup(){
		$this->config = parse_ini_file('../.config/config.ini');
		$this->verify = $this->config['recaptcha'];
		$this->adminEmail = $this->config['Email'];
		try{
			$this->PDOConnection = new PDO("mysql:host=".$this->config['dburl'] ."; dbname=".$this->config['dbname'],$this->config['username'],"");
			$this->PDOConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
	}

	
	
	public function getConnection(){
		
			return $this->PDOConnection;
	}

	public function getVerify(){
		return $this->verify;
	}

	public function getAdminEmail(){
		return $this->adminEmail;
	}
}
?>