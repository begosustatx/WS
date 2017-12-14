<?php
    session_start();
	//Konprobatuko dugu erabiltzaileak nick bat sartu duela
	if (empty($_SESSION["nick"])) {
		echo "<script> window.location.assign('nickaSartu.php');</script>";
		exit();
	}

?> 