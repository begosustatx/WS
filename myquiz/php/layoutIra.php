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
	
	if(!isset($posta) && empty($posta))
		echo "<script> window.location.assign('../html/layout.html');</script>";
	
	// Zihurtatu irakaslearen rola.
	segurtasunaIrakaslea();
	
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
		<span><a href='reviewingQuizes.php'>Review a Quizz</a></span>
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