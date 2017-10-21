<?php
	$local = 0;
	if($local == 0 ){
		$server="localhost:1234";
		$user="root";
		$pass="";
		$db="quiz";
	} else {
		$server="localhost:3306";
		$user="id2923223_apato001";
		$pass="1234abc";
		$db="id2923223_quiz";
	}
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
		}
	//argazkia igo dela konprobatzeko
	if(isset($_POST['bidali']))
	{	$imgData =addslashes (file_get_contents($_FILES['argazkia']['tmp_name']));
		$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa, argazkia) VALUES ('$_POST[posta]', '$_POST[testua]', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]','{$imgData}')";
		$ema = mysqli_query($link, $sql);
		if(!$ema){
			echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
			echo "<a href='../html/addQuestionHTML5.html'>Berriro saiatu</a>";
		}else {
			echo  "<p> Ondo txertatu da.</p>";
			echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='showQuestionsWithImages.php'>hemen</a></p>" ;
		}
	}
		mysqli_close($link); // Konexioa itxi
?>