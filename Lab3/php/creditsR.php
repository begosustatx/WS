<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Credits</title>
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
	$email=$_GET['email'];
	if(!(isset($_GET['email'])) && empty($_GET['email']))
		echo "<script> window.location.assign('../html/layout.html');</script>"; 
	include 'dbconfig.php';
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$sql="SELECT * FROM erabiltzaileak WHERE posta='$email'";
		if($ema=mysqli_query($link, $sql)){
			$dago=mysqli_num_rows($ema);
			mysqli_close($link); // Konexioa itxi
			if($dago==0) // ez bada existitzen horrelako erabiltzailerik anonimoen layout-era joan.
			echo "<script> window.location.assign('../html/layout.html');</script>"; 
			mysqli_free_result($ema);
		} 
  ?>
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
		<h1>Credits</h1>

		</br>
		<table>
			<tr>
				<td>
					<h3>Deitura:</h3>
				</td>
				<td>
					<h3>Deitura:</h3>
				</td>
			</tr>
			<tr>
				<td>
					<p>Ainhoa</p>
				</td>
				<td>
					<p>Begoña</p>
				</td>
			</tr>
			<tr>
				<td>
					<h3>Espezialitatea</h3>
				</td>
				<td>
					<h3>Espezialitatea</h3>
				</td>
			</tr>
			<tr>
				<td>
					<p>Konputagailu Ingeniaritza</p>
				</td>
				<td>
					<p>Software Ingeniaritza</p>
				</td>
			</tr>
			<tr>
				<td>
					<img src="../img/ainhoa.jpg" width="450px"></img>
				</td>
				<td>
					<img src="../img/begona.jpg" width="450px"></img>
				</td>
			</tr>
		</table>	
	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
	</footer>
  </body>
</html>