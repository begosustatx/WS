<?php include 'segurtasuna.php';?>
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
	$erregistratua=-1;
	
	if(!(isset($_SESSION['mail'])) && empty($_SESSION['mail'])){
		$erregistratua=0; 
	} else
		$email=$_SESSION['mail'];
	if($erregistratua<0){
		include 'dbconfig.php';
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$sql="SELECT * FROM erabiltzaileak WHERE posta='$email'";
			if($ema=mysqli_query($link, $sql)){
				$dago=mysqli_num_rows($ema);
				mysqli_close($link); // Konexioa itxi
				if($dago==0) // ez bada existitzen horrelako erabiltzailerik anonimoa da.
					$erregistratua=0; 
				mysqli_free_result($ema);
			}
		// Zihurtatu irakaslearen rola.
		if(segurtasunaIrakaslea()==1)
			$erregistratua=2;
		// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
		if(segurtasunaIkaslea()==1)
			$erregistratua=1;
	}	
  ?>
	<div id='page-wrap'>
		<?php // Ikaslearen rola
		if($erregistratua==1){ ?>
		<header class='main' id='h1'>
			<div class="right">
				<span><a href="logOut.php?email=<?php echo $email; ?>">LogOut</a> </span>
				<span> Hello <?php echo $email; ?> :)</span>
			</div>
			<h2>Quiz: crazy questions</h2>
		</header>
		<nav class='main' id='n1' role='navigation'>
			<span><a href='layout.php'>Home</a></span>
			<span><a href='handlingQuizes.php'>Handle a Quizz</a></span>
			<span><a href='credits.php'>Credits</a></span>
			<span><a href='pasahitzaAldatu.php'>Change your password</a></span>
		</nav>
		<?php // Anonimoen rola
		} else if($erregistratua==0) {?>
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
		<?php // Irakaslearen rola.		
		} else if($erregistratua==2){?>
		<header class='main' id='h1'>
			<div class="right">
				<span><a href="logOut.php?email=<?php echo $email; ?>">LogOut</a> </span>
				<span> Hello <?php echo $email; ?> :)</span>
			</div>
			<h2>Quiz: crazy questions</h2>
		</header>
			<nav class='main' id='n1' role='navigation'>
				<span><a href='layout.php'>Home</a></span>
				<span><a href='reviewingQuizes.php'>Review a Quizz</a></span>
				<span><a href='credits.php'>Credits</a></span>
			</nav>
		<?php } else echo "<script> window.location.assign('layout.php');</script>";?>
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