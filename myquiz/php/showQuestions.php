<?php
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	
	$galderak=mysqli_query($link, "select * from questions");
	echo '<table border=1><tr><th> Posta </th><th> Testua </th><th> Erantzun zuzena </th><th> Erantzun okerra 1 </th><th> Erantzun okerra 2 </th><th> Erantzun okerra 3 </th><th> Zailtasuna </th><th> Gaiarloa </th></tr>';
	while($row = mysqli_fetch_array($galderak)){
		echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td></tr>';
	}
	echo '</table>';
	mysqli_close($link); // Konexioa itxi
?>