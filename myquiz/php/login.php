<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Login</title>
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
	<form method="post" id="login" name="login">
		<?php
			if(isset($_GET['email'])){
				echo 'Email: <input type="email" name="posta" id="posta" value="' . $_GET['email'] . '" autofocus />';
				
			} else{
				echo 'Email: <input type="email" name="posta" id="posta" placeholder="example@ikasle.ehu.es" autofocus />';
			}
?>
		<br>
		Password: <input type="password" name="pass" id="pass"/>
		<input type="submit" id="bidali" name="bidali" value="Login"/>
	</form>
	<a href="../html/layout.html">
				<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>
  </body>
</html>
<?php 
	if(isset($_POST['posta']) && !empty($_POST['posta'])){
		$usr_mail=$_POST['posta'];
		include 'dbconfig.php';
		$link = new mysqli($server, $user, $pass, $db) or die ("Error while connecting to data base.");
		if(isset($_POST['pass']) && !empty($_POST['pass'])){
			$usr_pass=$_POST['pass'];
			$sql="SELECT * FROM erabiltzaileak WHERE posta='$usr_mail' and pasahitza='$usr_pass'";
			$result=$link->query($sql);
			if(!($result)){
				echo "Error in the query" . $result->error;
			} else {
				session_start (); 
				$_SESSION['mail'] = $usr_mail;
				if($usr_mail == 'web000@ehu.es'){
					$_SESSION["kautotua"]= "IRAKASLEA";
					header('location: layoutIra.php');
				}
				else{
					$_SESSION["kautotua"]= "IKASLEA";
					header('location: layoutR.php');
				}
				$rows_cont = $result->num_rows;
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$link->close();
				if($rows_cont==1){
					$rows_cont=0;
					$xml = simplexml_load_file('../xml/counter.xml'); 
					//$kont = $xml->addChild('counter');
					$posta = $xml->addChild('count');
					$posta->addChild('posta', $usr_mail);
					$xml->asXML('../xml/counter.xml');
					
				} else 
					echo "<script> alert('Authentication failure!') </script>";
			}
		} else echo "<script> alert('You have to enter your password!') </script>";
	}
?>