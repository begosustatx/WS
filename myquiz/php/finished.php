<?php include 'segurtasuna.php'; segurtasunaAnonimo();?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Finish</title>
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
		<?php $nick = $_SESSION['nick']; $total = count($_SESSION['galderak'.$nick])-1; $zuzenak=$_SESSION['zuzenak'];?>
		<section class="main" id="s1">
			Correct answers:  <?php echo $zuzenak;?>
			Total questions: <?php echo $total;?><br>
			<?php
				$batura=0;
				$i=0;
				include 'dbconfig.php';
				array_pop($_SESSION['galderak'.$nick]);
				$link = mysqli_connect($server, $user, $pass, $db) or die ("Error while connecting to data base.");
				while($i<$total){
					//print_r($_SESSION['galderak'.$nick]);
					$id = array_pop($_SESSION['galderak'.$nick]);
					$sql = "SELECT * FROM questions WHERE ID='$id'";
					$result=mysqli_query($link, $sql);
					if(!($result))
						echo "Error in the query" . $result->error;
					$row = mysqli_fetch_array($result);
					$batura = $batura + $row['zailtasun'];
					$i=$i+1;
				}
			?>
			Complexity average: <?php echo (int)($batura/$total);?><br>
			<?php 
			//Galderen kontagailuaren array-a null-era jarri
				$_SESSION['galderak'.$nick]=null;
			?>
			<a href="quizzes2.php?puntuazioa=0">
				<img src="../img/back.png" style="width:42px;height:42px;border:0;">
			</a>
		</section>
		<footer class='main' id='f1'>
			<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
			<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
		</footer>
	  </div>
  </body>
</html>