<?php

	function segurtasunaIrakaslea(){
		// Sesio hasiera kanpotik egiten da.
		//session_start();
		// ERABILTZAILEA IRAKASLE MODUAN KAUTOTURIK DAGOELA EGIAZTATU 
		if ($_SESSION["kautotua"] != "IRAKASLEA") {
			// existitzen ez bada, berriro kautotzera bidaltzen dut
			echo "<script> window.location.assign('../html/layout.html');</script>";
			// gainera, script-atik irtetzen gara
			exit();
		}
	}
	
	function segurtasunaIkaslea(){
		// Sesio hasiera kanpotik egiten da.
		//session_start();
		// ERABILTZAILEA IKASLE MODUAN KAUTOTURIK DAGOELA EGIAZTATU 
		if ($_SESSION["kautotua"] != "IKASLEA") {
			// existitzen ez bada, berriro kautotzera bidaltzen dut
			echo "<script> window.location.assign('../html/layout.html');</script>";
			// gainera, script-atik irtetzen gara
			exit();
	}
	}
?> 