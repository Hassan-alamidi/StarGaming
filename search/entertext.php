<?php
	include("dbconnect.php");
	
	$namesound=metaphone($_POST['name']);
	$keywordsound=metaphone($_POST['keywords']);
	$username = sha1($_POST['username']);
	$password = sha1($_POST['password']);
	if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
	}else{
		header("Location:../index.html");
		
	}
	if($captcha){
		$response=file_get_contents($verify.$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		if($response.success==false){
			header("Location:../index.html");
		}else{
			if(!empty($_POST['title'])){
				header("Location:../index.html");
			}else{
				$uploadpassword = $connect->prepare("SELECT test1a, test2 FROM testDB WHERE test1a= ? AND test2= ? ");
				if ( false===$uploadpassword ) {
					die('failed error 1 ' . htmlspecialchars($sqlvalue->error));
				}
				$uploadpassword->bind_param("ss", $username, $password);
				if ( false===$uploadpassword ) {
					die('failed error 2 ' . htmlspecialchars($sqlvalue->error));
				}
				$uploadpassword->execute();
				if ( false===$uploadpassword ) {
					die('failed error 3 ' . htmlspecialchars($sqlvalue->error));
				}
				$uploadpassword->store_result();
				if ( false===$uploadpassword ) {
					die('failed error 4 ' . htmlspecialchars($sqlvalue->error));
				}
				$uploadpassword->bind_result($DBusername, $userpassword);
				$uploadpassword->fetch();
				if($username===$DBusername && $password===$userpassword){
					$sql= $connect->prepare("INSERT INTO SearchPG (PGName, PGDescription, PGKeywords, PGUrl, PGImgUrl, PGReleaseDate, PGPublishDate) VALUES (?, ?, ?, ?, ?, ?, ?)"); 
					//read pages in browser before continuing
					$sqlID = $connect->prepare("SELECT MAX(PGID) FROM SearchPG");
					
					$sqlmeta = $connect->prepare("INSERT INTO metaphonetext (NameSound, KeywordSound, PGID) VALUES (?, ?, ?)");
					if ( false===$sql && false===$sqlID && false===$sqlmeta) {
					die('failed error 5 ' .htmlspecialchars($sql->error).htmlspecialchars($sqlID->error).htmlspecialchars($sqlmeta->error));
					}else{
						
						$sql->bind_param("sssssss", $_POST['name'], $_POST['description'], $_POST['keywords'], $_POST['url'], $_POST['imgurl'], $_POST['releasedate'], $_POST['publishdate']);
						$sql->execute();
						$sqlID->execute();
						$sqlID->bind_result($maxID);
						$sqlID->fetch();
						$sqlmeta->bind_param("sss", $namesound, $keywordsound, $maxID);
						if ( false===$sql && false===$sqlID && false===$sqlmeta) {
							die('failed error 6 ' .htmlspecialchars($sql->error).htmlspecialchars($sqlID->error).htmlspecialchars($sqlmeta->error));	
						}else{
							$sqlID->close();
							$sqlmeta->execute();
							if ( false===$sql && false===$sqlmeta) {
								die('failed error 7 ' .htmlspecialchars($sql->error).htmlspecialchars($sqlmeta->error));	
							}else{
								$sql->close();
								$sqlmeta->close();
								echo "worked";
							}
						}
					}
					
				}else{
					echo "failed to check password";
				//header("Location:../index.html");
				
				}
			}
		}
	}else{
		header("Location:../index.html");
	}
?>