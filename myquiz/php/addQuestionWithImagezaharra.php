<?php
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
		}
		
		$onartuak = array("image/jpg", "image/jpeg", "image/gif", "image/png");
		if(in_array($_FILES['argazkia']['type'], $onartuak)){ // Argazkia igo dela konprobatzeko
			$img_tmp = $_FILES['argazkia']['tmp_name']; // Argazkiaren PATH.
			$mota = $_FILES['argazkia']['type']; // Argazkiaren mota.
			$imgData = mysqli_escape_string($link, file_get_contents($img_tmp));
			$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa, argazkia, arg_mota) VALUES ('$_POST[posta]', '$_POST[testua]', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]','$imgData', '$mota')";
			$ema = mysqli_query($link, $sql);
			if(!$ema){
				echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
				echo "<a href='../html/addQuestionHTML5.html'>Berriro saiatu</a>";
			}else {
				echo  "<p> Ondo txertatu da.</p>";
				echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='showQuestionsWithImages.php'>hemen</a></p>" ;
			}
		} else { // Argazkia ez bada sartzen
			$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa) VALUES ('$posta', '$testua', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]')";
			
			$ema = mysqli_query($link, $sql);
			if(!$ema){
				echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
				echo "<a href='../html/addQuestionHTML5.html'>Berriro saiatu</a>";
			}else {
			echo  "<p> Ondo txertatu da.</p>";
			echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='showQuestionsWithImages.php'>hemen</a></p>" ;
			}
		}
	} else echo "Bidalketan errorea egon da.";
	mysqli_close($link); // Konexioa itxi
?>