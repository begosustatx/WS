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
  <?php
	$email=$_GET['email'];
	if(!(isset($_GET['email'])) || empty($_GET['email']))
		header("location: ../html/layout.html");
  ?>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
	<div class="right">
      <span><a href="logOut.php?email=<?php echo $email; ?>">LogOut</a> </span>
	  <span> Hello <?php echo $email; ?> :)</span>
	</div>
	<h2>Quiz: crazy questions</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layoutR.php?email=<?php echo $email;?>'>Home</a></span>
		<span><a href='/quizzes'>Quizzes</a></span>
		<span><a href='addQuestionWithImage.php?email=<?php echo $email;?>'>Add Question</a></span>
		<span><a href='showQuestionsWithImages.php?email=<?php echo $email;?>'>Show Questions</a></span>
		<span><a href='creditsR.php?email=<?php echo $email;?>'>Credits</a></span>
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