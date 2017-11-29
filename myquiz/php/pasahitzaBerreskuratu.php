<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Restore Password</title>
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
	Sartu erabilitako posta:
	<form method="post">
		<input type="text" id="posta" name="posta"/>
		<input type="submit" id="botoia" name="botoia" value="Send"/>
	</form>
	<a href="login.php">
				<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>
<?php
	if(isset($_POST['posta']) && !empty($_POST['posta'])){
		// Zihurtatu email hori datu-basean dagoela.
		include 'dbconfig.php';
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$to = $_POST['posta'];
		$sql="SELECT * FROM erabiltzaileak WHERE posta = '$to'";
		
		if($ema=mysqli_query($link, $sql)){
			$dago=mysqli_num_rows($ema);
			
			if($dago==0){ // ez bada existitzen horrelako erabiltzailerik anonimoen layout-era joan.
				echo "<script> alert('Erabiltzailea hori ez dago erregistratuta') </script>";
				exit();
			}
			mysqli_free_result($ema);
		}
	
		// mail-a bidaltzeko datuak:
		$pasahitzBerria='12345abcd';
		$to = $_POST['posta'];
		$subject = "Restore password";
		$msg = "Your new password will be ".$pasahitzBerria.", please change it once you get in.";
		$header = "From: webmaster@quizzes.com";
		$bidali=mail($to, $subject, $msg, $header);
		if(!$bidali)
			echo "<script> alert('Error sending the restore mail.');</script>";
		else{
			$sql="UPDATE  erabiltzaileak  SET pasahitza='$pasahitzBerria' WHERE posta ='$to'";
			mysqli_query($link, $sql);
			echo "<script> alert('Mail sent.');</script>";
			mysqli_close($link); // Konexioa itxi
			echo "<script> window.location.assign('../php/login.php');</script>"; 
			
		}
	}
?>
  </body>
</html>