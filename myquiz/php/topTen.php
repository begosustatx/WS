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
	?>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
	</footer>
</div>


</body>
</html>