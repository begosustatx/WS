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
		$pass="***";
		$db="id2923223_quiz";
	}
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
		}
		
		$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa) VALUES ('$_POST[posta]', '$_POST[testua]', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]')";
			
		$ema = mysqli_query($link, $sql);
		if(!$ema){
				echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
				echo "<a href='../html/addQuestionHTML5.html'>Berriro saiatu</a>";
		}else {
			echo  "<p> Ondo txertatu da.</p>";
			echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='showQuestions.php'>hemen</a></p>" ;
		}
		mysqli_close($link); // Konexioa itxi
?>