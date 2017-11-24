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
<?php
	if(isset($_POST['posta']) && !empty($_POST['posta'])){
		// Zihurtatu email hori datu-basean dagoela.
		
		// mail-a bidaltzeko datuak:
		$to = $_POST['posta'];
		$subject = "Restore password";
		$msg = "You can't restore your password in this link <a href=''></a>";
		$header = "From: webmaster@quizzes.com";
		if(!mail($to, $subject, $msg, $header))
			echo "<script> alert('Error sending the restore mail.');</script>";
	}
?>
  </body>
</html>