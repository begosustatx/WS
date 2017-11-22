<?php
	
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	
	$aktualizatu=mysqli_query($link, "UPDATE questions SET testua='$_POST[testua]', eZuzen='$_POST[eZuzen]', eOker1='$_POST[eOker1]', eOker2='$_POST[eOker2]', eOker3='$_POST[eOker3]', zailtasun='$_POST[zailtasun]', gaiarloa='$_POST[gaiarloa]' WHERE ID='$_POST[ID]'");
	if(mysqli_errno()){
		echo "Queryan hutxegitea MySQLn: " . mysqli_error();
		exit();
	}
	echo "<script> window.location.assign('reviewingQuizes.php');</script>";
?>