<?php
	$irteera= "";
	sleep(2);
	$testua=$_GET["testua"];
	$zailtasun=$_GET["zailtasun"];
	$gaiarloa=$_GET["gaiarloa"];
	$eZuzen=$_GET["eZuzen"];
	$eOker1=$_GET["eOker1"];
	$eOker2=$_GET["eOker2"];
	$eOker3=$_GET["eOker3"];
	//posta nola bidali?? 
	//argazkia ere bidali ahal izango da?
	if (empty($testua) || empty($zailtasun) || empty($gaiarloa) || empty($eZuzen) || empty($eOker1) || empty($eOker2)|| empty($eOker3)){
		echo "Berrigorrezko eremu guztiak bete";
	}	
	else {
		
		if(strlen($testua)<9){
			echo "Galderaren testu motzegia";
		}  
		else{		
			// Balio egokiak sartu badira XML fitxategia kargatu.
			$xml = simplexml_load_file('../xml/questions.xml'); 
		
			include 'dbconfig.php';
			$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
			if (mysqli_connect_errno()){
				echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
				exit();
			}
			/*	
			$onartuak = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			if(in_array($_FILES['argazkia']['type'], $onartuak)){ // Argazkia igo dela konprobatzeko
				$img_tmp = $_FILES['argazkia']['tmp_name']; // Argazkiaren PATH.
				$mota = $_FILES['argazkia']['type']; // Argazkiaren mota.
				$imgData = mysqli_escape_string($link, file_get_contents($img_tmp));
				$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa, argazkia, arg_mota) VALUES ('$posta', '$_POST[testua]', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]','$imgData', '$mota')";
				$ema = mysqli_query($link, $sql);
				if(!$ema){
					echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
					echo "<a href='../html/addQuestionHTML5.html'>Berriro saiatu</a>";
				}else {
					$nquestion = $xml->addChild('assessmentItem');
					$nquestion->addAttribute('complexity', $_POST['zailtasun']);
					$nquestion->addAttribute('subject', $_POST['gaiarloa']);
					$text = $nquestion->addChild('itemBody');
					$text->addChild('p', $_POST['testua']);
					$qC = $nquestion->addChild('correctResponse');
					$qC->addChild('value', $_POST['eZuzen']);
					$qIs = $nquestion->addChild('incorrectResponses');
					$qIs->addChild('value', $_POST['eOker1']);
					$qIs->addChild('value', $_POST['eOker2']);
					$qIs->addChild('value', $_POST['eOker3']);
					$xml->asXML('../xml/questions.xml'); // Aldaketak XML fitxategian gorde
					echo  "<br><p> Ondo txertatu da DB-an eta XML-ean.</p>";
				}
			} else { // Argazkia ez bada sartzen*/
				$sql="INSERT INTO questions(testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa) VALUES ('$testua', '$eZuzen', '$eOker1', '$eOker2', '$eOker3', '$zailtasun', '$gaiarloa')";
					
				$ema = mysqli_query($link, $sql);
				if(!$ema){
					echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
					echo "<a href='../html/addQuestionHTML5.html'>Berriro saiatu</a>";
				}else {
					$nquestion = $xml->addChild('assessmentItem');
					$nquestion->addAttribute('complexity', $zailtasun);
					$nquestion->addAttribute('subject', $gaiarloa);
					$text = $nquestion->addChild('itemBody');
					$text->addChild('p', $testua);
					$qC = $nquestion->addChild('correctResponse');
					$qC->addChild('value',$eZuzen);
					$qIs = $nquestion->addChild('incorrectResponses');
					$qIs->addChild('value', $eOker1);
					$qIs->addChild('value', $eOker2);
					$qIs->addChild('value', $eOker3);
					$xml->asXML('../xml/questions.xml'); // Aldaketak XML fitxategian gorde
					echo  "<br><p> Ondo txertatu da DB-an eta XML-ean.</p>";
				}
			//} 
			mysqli_close($link); // Konexioa itxi
		}
	}

?>