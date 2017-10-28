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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
	$(document).ready(function(){
		
		/* Formularioaren balidazioa egiten duen funtzioa. */
		$("#login").click(function(){
			console.log("Login funtzioan");
			var pass = $("#pass").val();
			var pass2 = $("#pass2").val();
			var deitura =$("#deitura");
			var nick =$("#nick");
			var posta =$("#posta");

			
			if(pass.length<("6")|| pass2.length<("6")){
				alert("Pasahitzak gutxienez 6 karaktere izan behar ditu");
				return false;
			} 
			else if(pass!=pass2){
				alert("Sartutako bi pasahitzak berdinak izan behar dira");
				return false;
			}
			else {
				console.log("dena zuzen");
				console.log("Bidaliko diren datuak: posta " + posta + " deitura: " + deitura + " nick " + nick);
				console.log(" pasahitza1: " + pass + " pasahitza2: " + pass2);
				alert("Emaitza bidali da.");
			} 
				
		});
		
		/* Reseteatu irudia 
		$("#reset").click(function(){
			$("#ikusiarg").removeAttr("src");
		});
	
		Irudia kargatzen bada erakutsi pantailan 
		$("#argazkia").change(function(e){
			console.log("argazkia aldatu da.");
			var img = e.target.files[0], imageType = /image.;
			if (!img.type.match(imageType))
				return false;
			var reader = new FileReader();
			reader.onload = fileOnload;
			reader.readAsDataURL(img);
			
			function fileOnload(e) {
				var result=e.target.result;
				$("#ikusiarg").attr("src",e.target.result);
			}
		}); */
	});
	
  </script>
  </head>
  <body>
	<form method="post" id="signUp" name="signUp" action="../php/signUp.php" method="post" enctype="multipart/form-data">
		Email: <input type="email" name="posta" id="posta" pattern="^[a-z]{2,}[0-9]{3}@ikasle[.]ehu[.](eus|es)$" placeholder="example@ikasle.ehu.es" autofocus required />
		<br>
		Deitura: <input type="text" name="deitura" id="deitura" pattern="^[A-Z][a-z]{1,}[\s][A-Z][a-z]{1,}$" required/><br>
		Nick: <input type="text" name="nick" id="nick" pattern="^[A-Za-z]{1,}$" required/><br>
		Password: <input type="password" name="pass" id="pass" required/><br>
		Password-a errepikatu: <input type="password" name="pass2" id="pass2" required/><br>
		<input type="submit" id="bidali" name="bidali" value="Login"/>
	</form>
  </body>
  
</html>
<?php
	$local = 0;
	if($local == 0 ){
		$server="localhost";
		$user="root";
		$pass="";
		$db="quiz";
	} else {
		$server="localhost";
		$user="id2923223_apato001";
		$pass="***";
		$db="id2923223_quiz";
	}
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
		}
		
		$sql="INSERT INTO erabiltzaileak(posta, deitura, nick, pasahitza) VALUES ('$_POST[posta]', '$_POST[deitura]','$_POST[nick]', '$_POST[pass]')";
			
		$ema = mysqli_query($link, $sql);
		if(!$ema){
				echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
				echo "<a href='../html/signUp.php'>Berriro saiatu</a>";
		}else {
			echo  "<p> Ondo txertatu da.</p>";
		}
		mysqli_close($link); // Konexioa itxi
?>