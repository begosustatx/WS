<?php

    session_start();
	function segurtasunaIrakaslea(){
		// Sesio hasiera kanpotik egiten da.
		//session_start();
		// ERABILTZAILEA IRAKASLE MODUAN KAUTOTURIK DAGOELA EGIAZTATU 
		if ($_SESSION["kautotua"] != "IRAKASLEA") {
			// existitzen ez bada, berriro kautotzera bidaltzen dut
			return 0;
			// gainera, script-atik irtetzen gara
			exit();
		} else return 1;
	}
	
	function segurtasunaIkaslea(){
		// Sesio hasiera kanpotik egiten da.
		//session_start();
		// ERABILTZAILEA IKASLE MODUAN KAUTOTURIK DAGOELA EGIAZTATU 
		if ($_SESSION["kautotua"] != "IKASLEA") {
			// existitzen ez bada, berriro kautotzera bidaltzen dut
			return 0;
			// gainera, script-atik irtetzen gara
			exit();
		}else return 1;
	}
?> 