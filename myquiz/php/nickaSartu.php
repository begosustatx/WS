<?php session_start(); ?>
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
  <div id='page-wrap'>
	<header class='main' id='h1'>
	  <div class="right">
		  <span><a href="../php/login.php">LogIn</a> </span>
		  <span><a href="../php/signUp.php">SingUp</a> </span>
		  <span>Anonymous</span>
	  </div>
	<h2>Quiz: crazy questions</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='../php/layout.php'>Home</a></span>
		<span><a href='../php/quizzes.php'>Quizzes</a></span>
		<span><a href='../php/credits.php'>Credits</a></span>
	</nav>
 
	<section class="main" id="s1">
		<form id="galderaF" name="galderenF" method="post" enctype="multipart/form-data">

			<p>Sartu nick bat:</p>
			Nick: <input type="text" name="nick" id="nick" pattern="^[A-Za-z]{1,}$"/><br>
			<input type="submit" id="bidali" name="bidali" value="Bidali"/>

			</form>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
	</footer>
	

</div>
<?php
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	include "dbconfig.php"; 
	if(isset($_POST['bidali'])){
		if($_POST['nick']==''){
		echo "<script> alert('Nick bat sartu mesedez');</script>";
		}
		else{
			$link = mysqli_connect($server, $user, $pass, $db) or die ("Error while connecting to data base.");
			$sql="SELECT nick FROM anonimoak";
			$result=mysqli_query($link, $sql);
			if(!($result))
				echo "Error in the query" . $result->error;
			else {
				$erabilKonprobatu = true;
				while ($row = $result->fetch_assoc() and $erabilKonprobatu==true) {
					if(strnatcasecmp($row['nick'], $_POST['nick'])==0) { 
						$erabilKonprobatu = false; 
						
					} 
				} 
				
				if($erabilKonprobatu==true){
					$nick = $_POST['nick'];
					$nick = test_input($nick);
					$sql="INSERT INTO anonimoak VALUES ('$nick', '0')";
					$ema = mysqli_query($link, $sql);

						if(!$ema){
							echo "<script> alert('Errorea query-a gauzatzerakoan');</script>";
						}
						else {
							$_SESSION['nick']=$nick;
							echo "<script> window.location.assign('quizzes2.php?puntuazioa=0');</script>";
						} 
				}
				else{
					$_SESSION['nick']=$_POST['nick'];
					echo "<script> window.location.assign('quizzes2.php?puntuazioa=0');</script>";
				}
			}
		}
			
	}
	
	?>
</body>
</html>