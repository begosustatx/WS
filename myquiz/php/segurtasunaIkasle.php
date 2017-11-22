<?php
	//sesio hasiera
	session_start();
	// ERABILTZAILEA KAUTOTURIK DAGOELA EGIAZTATU // ERABILTZAILEA KAUTOTURIK DAGOELA EGIAZTATU
	if ($_SESSION["kautotua"] != "IKASLEA") {
		// existitzen ez bada, berriro kautotzera bidaltzen dut
		header("Location:../html/layout.html");
		//gainera, script-atik irtetzen gara
		exit();
	}
?> 