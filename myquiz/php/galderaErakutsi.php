<?php
	$testua = $_GET['testua'];
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	$galderak=mysqli_query($link, "select * from questions where testua = '$testua'");
	$row = mysqli_fetch_array($galderak);
	if($row['argazkia']==NULL){
		echo "<input type='hidden' id='ID' name='ID' value='" . $row['ID'] ."'/> <input name='testua' type='text' value='". $row['testua'] . "'/> <input name='eZuzen' type='text' value='". $row['eZuzen'] . "'/> <input name='eOker1' type='text' value='" . $row['eOker1'] . "'/> <input name='eOker2' type='text' value='" . $row['eOker2'] . "'/> <input name='eOker3' type='text' value='" . $row['eOker3'] . "'/> <input name='zailtasun' type='number' value='" . $row['zailtasun'] . "' max='5' min='1'/> <input name='gaiarloa' type='text' value='" . $row['gaiarloa'] . "'/> <input type='file' id='argazkia' name='argazkia'/>";
	} else
		echo "<input type='hidden' id='ID' name='ID' value='" . $row['ID'] ."'/> <input name='testua' type='text' value='". $row['testua'] . "'/> <input name='eZuzen' type='text' value='". $row['eZuzen'] . "'/> <input name='eOker1' type='text' value='" . $row['eOker1'] . "'/> <input name='eOker2' type='text' value='" . $row['eOker2'] . "'/> <input name='eOker3' type='text' value='" . $row['eOker3'] . "'/> <input name='zailtasun' type='number' value='" . $row['zailtasun'] . "' max='5' min='1'/> <input name='gaiarloa' type='text' value='" . $row['gaiarloa'] . "'/> <input type='file' id='argazkia' name='argazkia'/> <br> <img id='ikusiarg' src='data:" . $row['arg_mota'] . ";base64," . base64_encode($row['argazkia']) . "' width='300px' height='300px'>";
?>