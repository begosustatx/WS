<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Quizzes</title>
    <link rel='stylesheet' type='text/css' href='../stylesPWS/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../stylesPWS/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../stylesPWS/smartphone.css' />
  
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
	<form method="post" id="signUp" name="signUp" >
		
		Password zaharra: <input type="password" name="passZaha" id="pass"/><br> 
		Password berria : <input type="password" name="pass" id="pass"/><br> 
		Password-a errepikatu: <input type="password" name="pass2" /><br>
		
		<div id="pasahitza"></div><br>
		<input type="submit" id="bidali" name="bidali" value="Gorde"/>
	</form>
	<a href="../php/layout.php">
				<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>
  <?php
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	include 'segurtasuna.php';
	
	$posta=$_SESSION['mail'];
	// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
	segurtasunaIkaslea();
	if(isset($_POST['bidali'])){
		if($_POST['pass'] == '' or $_POST['pass2'] == '' or $_POST['passZaha'] == ''){
			echo "<script> alert('Eremu guztiak bete');</script>";
		}
		elseif(strlen($_POST['pass'])<5){
			echo "<script> alert('Pasahitzak 6 karaktere gutxienez izan behar du');</script>";
		}
		
		else{
			$sql="SELECT pasahitza FROM erabiltzaileak WHERE posta='$posta'";
			$result=mysqli_query($link, $sql);
			$row = mysqli_fetch_array($result);
			$hash = crypt($_POST['passZaha'], '$5$rounds=5000$WebSistemak$');
			if($row['pasahitza']!=$hash){ // Hau erabiltzea seguruagoa da.
				echo "<script> alert('Pasahitza okerra');</script>";
			}
			else{
				if($_POST['pass']==$_POST['pass2']){
					 // Pasahitza enkritatu
					$hash1 = crypt($_POST['pass'], '$5$rounds=5000$WebSistemak$');
					$sql="UPDATE  erabiltzaileak  SET pasahitza='$hash1' WHERE posta ='$posta'";
					mysqli_query($link, $sql);
					echo "<script> alert('Pasahitza aldatuta');</script>";
					mysqli_close($link); // Konexioa itxi
					echo "<script> window.location.assign('layout.php');</script>"; 
				}
				else{
					echo "<script> alert('Pasahitzak berdinak izan behar dira');</script>";
				}
			}
		}
	}
  ?>
 
</body>
</html>