<?php
	$xml= simplexml_load_file("../xml/questions.xml");
	echo '<table border=1><tr><th> Testua </th><th> Zailtasuna </th><th> Gaiarloa </th></tr>';
	foreach($xml->assessmentItem as $question){
		echo '<tr><td>' . $question->itemBody->p . '</td><td>' . $question['complexity'] . '</td><td>' . $question['subject'] . '</td></tr>';
	}
	
?>