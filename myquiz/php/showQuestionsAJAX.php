<?php
	$irteera= "";
	sleep(2);
	echo"<script>console.log('php barruan');</script>";
	// Kargatu galderen XML-a
	$xml = simplexml_load_file('../xml/questions.xml'); 
	// Taularen goiburukoa
	echo '<table border=1 style="border-collapse:collapse;background-color:#ffffff;"><tr><th> Testua </th><th> Zailtasuna </th><th> Gaiarloa </th></tr>';
	// Taula bete:
	foreach($xml->assessmentItem as $question){
		$irteera .= "<tr><td>" . $question->itemBody->p . "</td><td>" . $question['complexity'] . "</td><td>" . $question['subject'] . "</td></tr>";
	}
	echo $irteera;
	?>