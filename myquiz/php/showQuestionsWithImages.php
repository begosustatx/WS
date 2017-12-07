<?php include 'segurtasuna.php';?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Show Quizzes</title>
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
		td {padding: 10px;}
	</style>
  </head>
  
  <body>
	<?php

	include 'dbconfig.php';
	
	if(!isset($_SESSION['mail']) && empty($_SESSION['mail']))
		echo "<script> window.location.assign('layout.php');</script>";

	// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
	if(segurtasunaIkaslea()==0){
		echo "<script> window.location.assign('layout.php');</script>";
	} else {
		$posta=$_SESSION['mail'];
		// Konprobatu erabiltzailea datu basean dagoen.
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$sql="SELECT * FROM erabiltzaileak WHERE posta = '$posta'";
		if($ema=mysqli_query($link, $sql)){
			$dago=mysqli_num_rows($ema);
			mysqli_close($link); // Konexioa itxi
			if($dago==0){ // ez bada existitzen horrelako erabiltzailerik anonimoen layout-era joan.
				echo "<script> alert('Erabiltzailea ez dago erregistratuta') </script>";
				echo "<script> window.location.assign('layout.php');</script>"; 
			}
			mysqli_free_result($ema);
		}
	}
	
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	
	$galderak=mysqli_query($link, "select * from questions");
	echo '<table border=1 style="border-collapse:collapse;background-color:#ffffff;"><tr><th> Posta </th><th> Testua </th><th> Erantzun zuzena </th><th> Erantzun okerra 1 </th><th> Erantzun okerra 2 </th><th> Erantzun okerra 3 </th><th> Zailtasuna </th><th> Gaiarloa </th> <th> Argazkia </th></tr>';
	while($row = mysqli_fetch_array($galderak)){
		if($row['argazkia']==NULL){
			echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td> <img src="../img/default.jpg" width="150px" height="150px" /></td></tr>';
		} else
			echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td> <img src="data:' . $row['arg_mota'] . ';base64,' . base64_encode($row['argazkia']) . '" width="150px" height="150px" /></td></tr>';
	}	
	echo '</table>';
	mysqli_close($link); // Konexioa itxi
  ?>
  </body>
</html>