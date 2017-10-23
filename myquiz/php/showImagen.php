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
	$img=mysqli_query($link, "SELECT * FROM questions WHERE id=" . $_GET['id']);
	$row=mysqli_fetch_assoc($img);
	
	header("Content-type:". $row['arg_mota']);
	echo $row['argazkia'];
?>