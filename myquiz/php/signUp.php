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

	<script src="../js/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#posta').change(function(){
				egiaztatuErabiltzailea($('#posta').val());
			});
			
		});
	  </script>
  <script type="text/javascript" language = "javascript">
	var xhro = new  XMLHttpRequest;
	function egiaztatuErabiltzailea(email){
		console.log("egiaztatuErabiltzaile funtzioaren barruan");
		var url="egiaztatuE.php?email="+email;
		xhro.open("GET",url, true);
		xhro.send();
	}
	xhro.onreadystatechange = function(){
		console.log("ErabiltzaileE status: "+xhro.readyState);
		if ((xhro.readyState==4)&&(xhro.status==200 )){
			document.getElementById("erabiltzaileE").innerHTML= xhro.responseText;
		}
	}
  </script>
  <script type="text/javascript" language = "javascript">
	$(document).ready(function(){
		$('#pass').change(function(){
			egiaztatuPasahitza($('#pass').val());
		});
		
	});
  </script>
  <script type="text/javascript" language = "javascript">
		xhro = new XMLHttpRequest();
		xhro.onreadystatechange = function(){
			if ((xhro.readyState==4)&&(xhro.status==200 )){ 
				document.getElementById("pasahitza").innerHTML= xhro.responseText;
			}
		}
		function egiaztatuPasahitza(pass){
			xhro.open("GET","egiaztatuPasahitza.php?pass="+pass, true);			
			xhro.send();
		}
  </script>
  </head>
  <body>
	<form method="post" id="signUp" name="signUp" enctype="multipart/form-data">
		Email: <input type="email" name="posta" id="posta" pattern="^[a-z]{2,}[0-9]{3}@(ikasle\.ehu|ehu)\.(eus|es)$" placeholder="example@ikasle.ehu.es" autofocus />
		<br>
		Deitura: <input type="text" name="deitura" id="deitura" pattern="[A-Z][a-z]+[\s][a-z\s]*[A-Z][a-z][\sa-z]*"  /><br>
		Nick: <input type="text" name="nick" id="nick" pattern="^[A-Za-z]{1,}$"/><br>
		Password: <input type="password" name="pass" id="pass"/><br> 
		Password-a errepikatu: <input type="password" name="pass2" /><br>
		<div id="pasahitza"></div><br>
		
		<p class="argazkia"><label for="argazkia"> Irudia: </label>
			<input type="file" id="argazkia" name="argazkia"/>
			</p>
			<img id="ikusiarg" src="" width="300px">
			<br>
		<input type="submit" id="bidali" name="bidali" value="SignUp"/>
	</form>
	<a href="../html/layout.html">
				<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>
	<?php
	include "dbconfig.php"; 
	require_once('lib/nusoap.php');
	require_once('lib/class.wsdlcache.php');
	$link = new mysqli($server, $user, $pass, $db) or die ("Error while connecting to data base.");
	
	if(isset($_POST['bidali']))
	{ 
		if($_POST['posta'] == '' or $_POST['deitura'] == '' or $_POST['nick'] == ''or $_POST['pass'] == ''or $_POST['pass2'] == '')
		{ 
			echo "<script> alert('Beharrezko datu guztiak sartu behar dituzu');</script>";
		} 
		else {
			$patroia='/^[a-z]{2,}[0-9]{3}@(ikasle\.ehu|ehu)\.(eus|es)$/';
			if(!preg_match($patroia,$_POST['posta'])){
				echo "<script> alert('Posta okerra');</script>";
			}
			if(!isset($_POST['nick']) || empty($_POST['nick'])){
				echo "<script> alert('Berrigorrezko eremu guztiak bete');</script>";
			}
			$patroia='/^[A-Z][a-z]+[\s][a-z\s]*[A-Z][a-z][\sa-z]*/';			
			if(!preg_match($patroia,$_POST['deitura'])){
				echo "<script> alert('Deitura okerra');</script>";
			}
			/*$soapclient1 = new nusoap_client('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl',true);
			
			$result1 = $soapclient1->call('egiaztatuE', array('x'=>$_POST['posta']));
			if ($result1 == 'EZ'){
				echo "<script> alert('Ez zaude matrikulatuta');</script>";
			}*/
			
			$soapclient2 = new nusoap_client('http://localhost:1234/Lab/Lab5/php/egiaztatu.php?wsdl',true);
			$result2 = $soapclient2->call('egiaztatu', array('x'=>$_POST['pass']));
			if ($result2 == 'BALIOGABEA'){
				echo "<script> alert('Pasahitza oso ahula');</script>";
			}
		}
			$postak=mysqli_query($link, "select * from erabiltzaileak");			
			$erabilKonprobatu = true;
			while($result = mysqli_fetch_array($postak, MYSQLI_ASSOC)) { 
				if($result['posta'] == $_POST['posta']) { 
						$erabilKonprobatu = false; 
				} 
			} 
			if($erabilKonprobatu == true) { 
				if((strcmp($_POST['pass'], $_POST['pass2'])==0) and (strlen($_POST['pass'])>5)){  
					if (is_uploaded_file($_FILES['argazkia']['tmp_name'])){
						$onartuak = array("image/jpg", "image/jpeg", "image/gif", "image/png");
						if(in_array($_FILES['argazkia']['type'], $onartuak)){ // Argazkia igo dela konprobatzeko
							$img_tmp = $_FILES['argazkia']['tmp_name']; // Argazkiaren PATH.
							$mota = $_FILES['argazkia']['type']; // Argazkiaren mota.
							$imgData = mysqli_escape_string($link, file_get_contents($img_tmp));
							$hash = crypt($_POST['pass'],'$5$rounds=5000$WebSistemak$'); // Pasahitza enkritatu
							$sql="INSERT INTO erabiltzaileak(posta, deitura, nick, pasahitza, argazkia, argazki_mota) VALUES ('$_POST[posta]', '$_POST[deitura]','$_POST[nick]', '$hash','$imgData', '$mota')";
							$ema = mysqli_query($link, $sql);
							if(!$ema){
								echo "<script> alert('Errorea query-a gauzatzerakoan: " . mysqli_error($link)."');</script>";
							}else {
								echo "<script> alert('Success. \n Going to home ...'); </script>";
								
								echo "<script> window.location.assign('login.php?email=" . $_POST['posta'] . "');</script>";
							}
						} 
				
					}
					else{
						$hash = crypt($_POST['pass'], '$5$rounds=5000$WebSistemak$'); // Pasahitza enkritatu
						$sql="INSERT INTO erabiltzaileak(posta, deitura, nick, pasahitza) VALUES ('$_POST[posta]', '$_POST[deitura]','$_POST[nick]', '$hash')";
						$ema = mysqli_query($link, $sql);
						if(!$ema){
							echo "<script> alert('Errorea query-a gauzatzerakoan: " . mysqli_error($link)."');</script>";
						}
						else {
							echo "<script> alert('Success. \n Going to home ...'); </script>";
							
							echo "<script> window.location.assign('login.php?email=" . $_POST['posta'] . "');</script>";
						} 
					}
				} else 
				{ 
					echo "<script> alert('Pasahitzak berdinak izan behar dira eta 6 karaktere baino gehiago izan.'); </script>"; 
				} 
			} 
			else 
			{ 
				echo "<script> alert('Dagoeneko existitzen da erabiltzaile hori.'); </script>";
			} 
		mysqli_close($link); // Konexioa itxi
	}
	
	
?>
  </body>
</html>