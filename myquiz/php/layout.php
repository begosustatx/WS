<?php include 'segurtasuna.php';?>
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
	function startFunction(){
			// console.log("Hasierako funtzio barruan.");
			setInterval(topten, 20000);
		}
	function topten(){
			var xhro = new  XMLHttpRequest;
			var url = "topTenTaula.php";
			
			xhro.onreadystatechange = function(){
				// console.log("Taularen status: "+xhro.readyState);
				if ((xhro.readyState==4)&&(xhro.status==200 )){
					document.getElementById("taula").innerHTML= xhro.responseText;
				} else 
					document.getElementById("taula").innerHTML = "<img src='../img/loading.gif' width=50px>";
			};
			xhro.open("GET",url, true);
			xhro.send();
		}	
  </script>
  <style>
	td {padding: 5px;}
	#taula {overflow-x: auto;}
  </style>
  </head>
  
  <body>
	<?php

	include 'dbconfig.php';
	
	
	$aurkitua=-1;
	
	if(!isset($_SESSION['mail']) && empty($_SESSION['mail'])){
		$aurkitua=0;
	} else 
		$posta=$_SESSION['mail'];

	
	if($aurkitua==-1){
		// Konprobatu erabiltzailea datu basean dagoen.
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$sql="SELECT * FROM erabiltzaileak WHERE posta = '$posta'";
		if($ema=mysqli_query($link, $sql)){
			$dago=mysqli_num_rows($ema);
			mysqli_close($link); // Konexioa itxi
			if($dago==0){ // ez bada existitzen horrelako erabiltzailerik anonimoa da.
				echo "<script> alert('Erabiltzailea ez dago erregistratuta') </script>";
				$aurkitua=0; 
			}
			mysqli_free_result($ema);
		}
		// Zihurtatu irakaslearen rola.
		if(segurtasunaIrakaslea()==1)
			$aurkitua=2;
		// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
		if(segurtasunaIkaslea()==1)
			$aurkitua=1;
	}
	
	if($aurkitua==0) {	?>
		<div id='page-wrap'>
			<header class='main' id='h1'>
				<div class="right">
				  <span><a href="login.php">LogIn</a> </span>
				  <span><a href="signUp.php">SingUp</a> </span>
				  <span>Anonymous</span>
				</div>
				<h2>Quiz: crazy questions</h2>
			</header>
			<nav class='main' id='n1' role='navigation'>
				<span><a href='layout.php'>Home</a></span>
				<span><a href='quizzes.php'>Quizzes</a></span>
				<span><a href='credits.php'>Credits</a></span>
			</nav>
			
	<?php // Irakaslearen rola:
	} else if($aurkitua==2){ 	 ?>

		<div id='page-wrap'>
			<header class='main' id='h1'>
			<div class="right">
			  <span><a href="logOut.php">LogOut</a> </span>
			  <span> Hello <?php echo $posta; ?> :)</span>
			</div>
			<h2>Quiz: crazy questions</h2>
			</header>
			<nav class='main' id='n1' role='navigation'>
				<span><a href='layout.php'>Home</a></span>
				<span><a href='reviewingQuizes.php'>Review a Quizz</a></span>
				<span><a href='credits.php'>Credits</a></span>
			</nav>		
	<?php // Ikaslearen rola:
 	} else if($aurkitua==1){ ?> 
 
		<div id='page-wrap'>
			<header class='main' id='h1'>
			<div class="right">
			  <span><a href="logOut.php">LogOut</a> </span>
			  <span> Hello <?php echo $posta; ?> :)</span>
			</div>
			<h2>Quiz: crazy questions</h2>
			</header>
			<nav class='main' id='n1' role='navigation'>
				<span><a href='layout.php'>Home</a></span>
				<span><a href='handlingQuizes.php'>Handle a Quizz</a></span>
				<span><a href='credits.php'>Credits</a></span>
				<span><a href='pasahitzaAldatu.php'>Change your password</a></span>
			</nav>
	<?php } else echo "<script> window.location.assign('login.php');</script>"; ?>
	<section class="main" id="s1">
				<div id="topten" style="text-align: center">
					<div id="taula">
					<h2> Top 10 Quizers </h2>
					<?php 
						include "dbconfig.php"; 
						$link = mysqli_connect($server, $user, $pass, $db) or die ("Error while connecting to data base.");
						$sql="select * from anonimoak ORDER BY puntuazioa desc LIMIT 10";
						$result=mysqli_query($link, $sql);
						if(!($result))
							echo "Error in the query" . $result->error;
						else{
							echo '<table border=1 style="border-collapse:collapse;background-color:#ffffff; "><tr><th> Nick-a </th><th> Puntuazioa </th></tr>';
							while($row = mysqli_fetch_array($result)){	
								echo '<tr><td>' . $row['nick'] . '</td><td>' . $row['puntuazioa'] . '</td></tr>';
							}	
							echo '</table>';	
							mysqli_close($link);
						}
					?></div>
					<script>startFunction();</script>
				</div>
			</section>
			<footer class='main' id='f1'>
				<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
				<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
			</footer>
		</div>
</body>
	
</html>