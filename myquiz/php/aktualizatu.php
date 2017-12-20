<?php
	function mssql_escape($str) {
       if(get_magic_quotes_gpc())
        $str= stripslashes($str);
       
       return str_replace("'", "''", $str);
    }
	$testua = mssql_escape($_POST['testua']);
	$eZuzen = mssql_escape($_POST['eZuzen']);
	$eOker1 = mssql_escape($_POST['eOker1']);
	$eOker2 = mssql_escape($_POST['eOker2']);
	$eOker3 = mssql_escape($_POST['eOker3']);
	$zailtasun = mssql_escape($_POST['zailtasun']);
	$gaiarloa = mssql_escape($_POST['gaiarloa']);
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
				$aktualizatu=mysqli_query($link, "UPDATE questions SET testua='$testua', eZuzen='$eZuzen', eOker1='$eOker1', eOker2='$eOker2', eOker3='$eOker3', zailtasun='$zailtasun', gaiarloa='$gaiarloa', argazkia='$imgData' WHERE ID='$_POST[ID]'");
				echo "<script> window.location.assign('reviewingQuizes.php');</script>";
		} else{
			$aktualizatu=mysqli_query($link, "UPDATE questions SET testua='$testua', eZuzen='$eZuzen', eOker1='$eOker1', eOker2='$eOker2', eOker3='$eOker3', zailtasun='$zailtasun', gaiarloa='$gaiarloa' WHERE ID='$_POST[ID]'");
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