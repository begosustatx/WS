<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Sign Up</title>
    <link rel='stylesheet' type='text/css' href='../stylesPWS/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../stylesPWS/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../stylesPWS/smartphone.css' />
  </head>
  <body>
	<form method="post" id="signUp" name="signUp"  method="post">
		Email: <input type="email" name="posta" id="posta" ="^[a-z]{2,}[0-9]{3}@ikasle[.]ehu[.](eus|es)$" placeholder="example@ikasle.ehu.es" autofocus autofocus />
		<br>
		Deitura: <input type="text" name="deitura" id="deitura" pattern="^[A-Z][a-z]{1,}[\s][A-Z][a-z]{1,}$"  /><br>
		Nick: <input type="text" name="nick" id="nick" pattern="^[A-Za-z]{1,}$"/><br>
		Password: <input type="password" name="pass" id="pass"/><br>
		Password-a errepikatu: <input type="password" name="pass2" /><br>
		<input type="submit" id="bidali" name="bidali" value="Login"/>
	</form>
  </body>
  
</html>
<?php
	session_start();
	include "dbconfig.php"; 
	$link = new mysqli($server, $user, $pass, $db) or die ("Error while connecting to data base.");
	
	if(isset($_POST['bidali']))
	{ 
		if($_POST['posta'] == '' or $_POST['deitura'] == '' or $_POST['nick'] == ''or $_POST['pass'] == ''or $_POST['pass2'] == '')
		{ 
			echo 'Beharrezko datu guztiak sartu behar dituzu';
		} 
		else 
		{ 
			$postak=mysqli_query($link, "select * from erabiltzaileak");			
			$erabilKonprobatu= true;
			while($result = mysqli_fetch_array($postak, MYSQLI_ASSOC)) { 
				if($result['posta'] == $_POST['posta']) { 
						$erabilKonprobatu = false; 
				} 
			} 
			if($erabilKonprobatu == true) { 
				if($_POST['pass'] == $_POST['pass2'] and strlen($_POST['pass'])>5){  
					$sql="INSERT INTO erabiltzaileak(posta, deitura, nick, pasahitza) VALUES ('$_POST[posta]', '$_POST[deitura]','$_POST[nick]', '$_POST[pass]')";
					mysql_query($sql); 
					$ema = mysqli_query($link, $sql);
					if(!$ema){
						echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
						echo "<a href='../html/signUp.php'>Berriro saiatu</a>";
					}
					else {
						echo  "<p> Ondo txertatu da.</p>";
						header('location: login.php'); 
					}
				} 
				else 
				{ 
					echo 'Pasahitzak berdinak izan behar dira eta 6 karaktere baino gehiago izan'; 
				} 
			} 
			else 
			{ 
				echo 'Sartutako postarekin badago beste erabiltzaile bat erregistratua'; 
			} 
		}
	
	}
	mysqli_close($link); // Konexioa itxi
	
?>