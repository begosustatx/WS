<?php
    session_start();
	//Konprobatuko dugu erabiltzaileak nick bat sartu duela
	if (empty($_SESSION["nick"])||empty($_SESSION["puntuazioa"]) ) {
		header("Location:../php/nickaSartu.php");
		exit();
	}

?> 