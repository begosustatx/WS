<?php
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	
	$galderak=mysqli_query($link, "select * from questions");
	echo '<table border=1><tr><th> Testua </th><th> Zailtasuna </th><th> Gaiarloa </th></tr>';
	while($row = mysqli_fetch_array($galderak)){
		echo '<tr><td>' . $row['testua'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td></tr>';
	}	
	echo '</table>';
	mysqli_close($link); // Konexioa itxi
	?>