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
	<?php
	session_start();
	include 'dbconfig.php';
	require_once('segurtasuna.php');
	
	$posta=$_SESSION['mail'];
	
	if(!isset($_SESSION['mail']) && empty($_SESSION['mail']))
		echo "<script> window.location.assign('../html/layout.html');</script>";

	// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
	segurtasunaIkaslea();

	// Konprobatu erabiltzailea datu basean dagoen.
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	$sql="SELECT * FROM erabiltzaileak WHERE posta = '$posta'";
	if($ema=mysqli_query($link, $sql)){
		$dago=mysqli_num_rows($ema);
		mysqli_close($link); // Konexioa itxi
		if($dago==0){ // ez bada existitzen horrelako erabiltzailerik anonimoen layout-era joan.
			echo "<script> alert('Erabiltzailea ez dago erregistratuta') </script>";
			echo "<script> window.location.assign('../html/layout.html');</script>"; 
		}
		mysqli_free_result($ema);
	}
  ?>

  <div id='page-wrap'>
	<header class='main' id='h1'>
	<div class="right">
      <span><a href="logOut.php">LogOut</a> </span>
	  <span> Hello <?php echo $posta; ?> :)</span>
	</div>
	<h2>Quiz: crazy questions</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layoutR.php'>Home</a></span>
		<span><a href='/quizzes'>Quizzes</a></span>
		<span><a href='handlingQuizes.php'>Handle a Quizz</a></span>
		<span><a href='addQuestionWithImage.php'>Add Question</a></span>
		<span><a href='showQuestionsWithImages.php'>Show Questions</a></span>
		<span><a href='creditsR.php'>Credits</a></span>
	</nav>
    <section class="main" id="s1">
    
	
	<div>
	Quizzes and credits will be displayed in this spot in future laboratories ...
	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>