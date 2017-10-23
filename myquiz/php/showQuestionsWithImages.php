<?php
    $local = 0;
	if($local == 0 ){
		$server="localhost";
		$user="root";
		$pass="";
		$db="quiz";
	} else {
		$server="localhost";
		$user="id2923223_apato001";
		$pass="1234abc";
		$db="id2923223_quiz";
	}
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	
	$galderak=mysqli_query($link, "select * from questions");
	echo '<table border=1><tr><th> Posta </th><th> Testua </th><th> Erantzun zuzena </th><th> Erantzun okerra 1 </th><th> Erantzun okerra 2 </th><th> Erantzun okerra 3 </th><th> Zailtasuna </th><th> Gaiarloa </th> <th> Argazkia </th></tr>';
	while($row = mysqli_fetch_array($galderak)){
		//$img=mysqli_query($link, "SELECT argazkia FROM questions WHERE id=" . $row['id']);
		echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td> <img src="showImage.php?id=' . $row['ID'] . '"/></td></tr>';
	}
	echo '</table>';
	mysqli_close($link); // Konexioa itxi
?>