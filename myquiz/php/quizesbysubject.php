<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Playing by subject</title>
    <link rel='stylesheet' type='text/css' href='../stylesPWS/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../stylesPWS/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../stylesPWS/smartphone.css' />
	<style>
		div {
			text-align: center;
			padding: 50px 50px 50px 50px;
		}
	</style>
   </head>
   <body>
   <div>
		<p>Hautatu dauden gaietatik:<p>
		<form id="gaiF" name="gaiF" method="get" action="playbysubject.php">
			<select name="subject" id="subject">
			<option>Select a subject</option>
		<?php
		include 'dbconfig.php';
			$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
			if (mysqli_connect_errno()){
				echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
				exit();
			}
			$galderak=mysqli_query($link, "SELECT DISTINCT gaiarloa from questions");
			
			while($row = mysqli_fetch_array($galderak)){
				echo "<option>" . $row['gaiarloa'] . "</option>";
			}
		?>
			</select>
			<input type="hidden" name="puntuazioa" value="0">
			<input type="submit" value="Play"/>
		</form>
	</div>
	<body>
<html>