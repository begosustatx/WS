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
  </head>
  <?php
	$email=$_GET['email'];
	if(!(isset($_GET['email'])) || empty($_GET['email']))
		header("location: ../html/layout.html");
  ?>
  <body>
	<header class='main' id='h1'>
	<div class="right">
      <span><a href="logOut.php?email=<?php echo $email; ?>">LogOut</a> </span>
	  <span> Hello <?php echo $email; ?> :)</span>
	</div>
	<h2>Quiz: crazy questions</h2>
	</header>
	<a href="layoutR.php?email=<?php echo $email; ?>">
		<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>

  <?php
   include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	
	$galderak=mysqli_query($link, "select * from questions");
	echo '<table border=1><tr><th> Posta </th><th> Testua </th><th> Erantzun zuzena </th><th> Erantzun okerra 1 </th><th> Erantzun okerra 2 </th><th> Erantzun okerra 3 </th><th> Zailtasuna </th><th> Gaiarloa </th> <th> Argazkia </th></tr>';
	while($row = mysqli_fetch_array($galderak)){
		if($row['argazkia']==NULL){
			echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td> <img src="../img/default.jpg" width="300px" height="300px" /></td></tr>';
		} else
			echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td> <img src="data:' . $row['arg_mota'] . ';base64,' . base64_encode($row['argazkia']) . '" width="300px" height="300px" /></td></tr>';
	}	
	echo '</table>';
	mysqli_close($link); // Konexioa itxi
  ?>
	
	<a href="layoutR.php?email=<?php echo $email; ?>">
		<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>
  </body>
</html>