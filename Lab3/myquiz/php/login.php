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
  </head>
  <body>
	<form method="post" id="login" name="login">
		Email: <input type="email" name="posta" id="posta" pattern="[a-z]{2,}[0-9]{3}@ikasle[.]ehu[.](eus|es)" placeholder="example@ikasle.ehu.es" autofocus required />
		<br>
		Password: <input type="password" name="pass" id="pass"/>
		<input type="submit" id="bidali" name="bidali" value="Login"/>
	</form>
  </body>
  
</html>
<?php
	if(isset($_POST['posta'])){
		$usr_mail=$_POST['posta'];
		include 'dbconfig.php';
		$link = new mysqli($server, $user, $pass, $db) or die ("Error while connecting to data base.");
		if(isset($_POST['pass'])){
			$usr_pass=$_POST['pass'];
			$sql="SELECT * FROM users WHERE posta='$usr_mail' and password='$usr_pass'";
			$result=$link->query($sql);
			if(!($result)){
				echo "Error in the query" . result->error;
			} else {
				$rows_cont = $result->num_rows;
				$link->close();
				if($rows_cont==1){
					$rows_cont=0;
					header('location: '); // Bete behar da.
				} else 
					else echo "<script> alert('Authentication failure!') </script>";
			}
		} 
	}
?>