<?php
	include 'segurtasuna.php';
	$posta=$_SESSION['mail'];
	sleep(2);
	include 'dbconfig.php';
	$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
	if (mysqli_connect_errno()){
		echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
		exit();
	}
	
	$galderak=mysqli_query($link, "select * from questions");
	$denak=mysqli_num_rows($galderak);
	$galderakp=mysqli_query($link, "select * from questions where posta = '$posta'");
	$norberanak=mysqli_num_rows($galderakp);
	echo $norberanak . " / " . $denak;
	mysqli_close($link);// Konexio itxi
	
?>