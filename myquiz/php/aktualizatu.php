<?php
	
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	if(isset($_POST['aldatuB'])){
		$onartuak = array("image/jpg", "image/jpeg", "image/gif", "image/png");
		if(in_array($_FILES['argazkia']['type'], $onartuak)){ // Argazkia igo dela konprobatzeko
				$img_tmp = $_FILES['argazkia']['tmp_name']; // Argazkiaren PATH.
				$mota = $_FILES['argazkia']['type']; // Argazkiaren mota.
				$imgData = mysqli_escape_string($link, file_get_contents($img_tmp));
				echo "<script> console.log('Argazkia aldatu behar da.');</script>";
				$aktualizatu=mysqli_query($link, "UPDATE questions SET testua='$_POST[testua]', eZuzen='$_POST[eZuzen]', eOker1='$_POST[eOker1]', eOker2='$_POST[eOker2]', eOker3='$_POST[eOker3]', zailtasun='$_POST[zailtasun]', gaiarloa='$_POST[gaiarloa]', argazkia='$imgData' WHERE ID='$_POST[ID]'");
				echo "<script> window.location.assign('reviewingQuizes.php');</script>";
		} else{
			$aktualizatu=mysqli_query($link, "UPDATE questions SET testua='$_POST[testua]', eZuzen='$_POST[eZuzen]', eOker1='$_POST[eOker1]', eOker2='$_POST[eOker2]', eOker3='$_POST[eOker3]', zailtasun='$_POST[zailtasun]', gaiarloa='$_POST[gaiarloa]' WHERE ID='$_POST[ID]'");
			echo "<script> window.location.assign('reviewingQuizes.php');</script>";
		} 

			
		if(!$aktualizatu){
			echo "Queryan hutxegitea MySQLn: " . mysqli_error();
			exit();
		}
	}
	if(isset($_POST['ezabatuB'])){
		$ezabatu = mysqli_query($link, "DELETE FROM questions WHERE ID='$_POST[ID]'");
		if(!$ezabatu){
			echo "Queryan hutxegitea MySQLn: " . mysqli_error();
			exit();
		} else
			echo "<script> window.location.assign('reviewingQuizes.php');</script>";
	}
?>