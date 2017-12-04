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
				echo 'Email: <input type="email" name="posta" id="posta" pattern="^[a-z]{2,}[0-9]{3}@(ikasle\.ehu|ehu)\.(eus|es)$" placeholder="example@ikasle.ehu.es" autofocus />';
			}
		?>
		<br>
		Password: <input type="password" name="pass" id="pass"/>
		<input type="submit" id="bidali" name="bidali" value="Login"/><br>
		<a href="pasahitzaBerreskuratu.php">Have you forgotten your password?</a>
	</form>
	<a href="../html/layout.html">
				<img src="../img/back.png" style="width:42px;height:42px;border:0;" onclick="sesioabukatu()">
	</a>
	<?php
	if(isset($_POST['posta']) && !empty($_POST['posta'])){ // Zihurtatu posta ondo pasa dela eta patroia betetzen duela.
		$patroia='/^[a-z]{2,}[0-9]{3}@(ikasle\.ehu|ehu)\.(eus|es)$/';
		if(!preg_match($patroia,$_POST['posta'])){
				echo "<script> alert('Posta okerra')</script>";
		} else {
			$usr_mail=$_POST['posta'];
			include 'dbconfig.php';
			$link = new mysqli($server, $user, $pass, $db) or die ("Error while connecting to data base.");
			if(isset($_POST['pass']) && !empty($_POST['pass'])){
				// Pasahitza enkriptatu:					
				$password = crypt($_POST['pass'], '$5$rounds=5000$WebSistemak$');
				$sql="SELECT pasahitza FROM erabiltzaileak WHERE posta='$usr_mail'";
				$result=mysqli_query($link, $sql);
				$row = mysqli_fetch_array($result);

				
				if(!($result)){
					echo "Error in the query" . $result->error;
					$_SESSION['saiakera'] = $usr_mail;
				} else {
					$rows_cont = $result->num_rows;
					$aurkitua = 0;
					if($rows_cont==0) 
						echo "<script> alert('Authentication failure!') </script>";
						session_start();
						
						if (empty($_SESSION['count'.$usr_mail])) 
							$_SESSION['count'.$usr_mail] = 1;
						echo 'Saiakera kopurua:'.$_SESSION['count'.$usr_mail];
						echo "<script>console.log('Kontagailua: ".$_SESSION['count'.$usr_mail]."');</script>";
					// 3 saiakera baino gehiago egin badira, kontua blokeatuta geldituko da.
					// Erabiltzaileak cachea garbitzen badu, sesioaren informazioa ere borratuko
					// denez, kontua desbloqueatuko da ere.
					if ($_SESSION['count'.$usr_mail]==3){
						echo "<script> alert('Kontua blokeatuta')</script>";
						echo "<script> window.location.assign('../html/layout.html');</script>";
						session_destroy();
					}
					else 
					$_SESSION['count'.$usr_mail]++;
					//while($row = $result->fetch_array(MYSQLI_ASSOC)){
						if($row['pasahitza']==$password){ // Hau erabiltzea seguruagoa da.
							$aurkitua = 1;
							$_SESSION['mail'] = $usr_mail;
							if($usr_mail == 'web000@ehu.es'){
								$_SESSION["kautotua"]= "IRAKASLEA";
								$_SESSION['count'.$usr_mail] = 1; // 
								echo "<script> window.location.assign('reviewingQuizes.php');</script>";
							} else {
								$_SESSION["kautotua"]= "IKASLEA";
								$_SESSION['count'.$usr_mail] = 1;
								echo "<script> window.location.assign('layoutR.php');</script>";
							}
						}
					//}
					
					$link->close(); // Konexioa itxi
					if($aurkitua==0)
						echo "<script> alert('Authentication failure!') </script>";	
							
				}
				 
			}
			else echo "<script> alert('You have to enter your password!') </script>";
		}
	}
	
?>
  </body>
  
</html>