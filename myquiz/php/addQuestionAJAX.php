<?php
	include 'segurtasuna.php';
	sleep(2);
	include 'dbconfig.php';	
	
	
	if(!isset($_SESSION['mail']) && empty($_SESSION['mail']))
		echo "<script> window.location.assign('layout.php');</script>";

	// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
	if(segurtasunaIkaslea()==0){
		echo "<script> window.location.assign('layout.php');</script>";
	} else {
		$posta=$_SESSION['mail'];
		$posta = test_input($posta);
		// Konprobatu erabiltzailea datu basean dagoen.
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$sql="SELECT * FROM erabiltzaileak WHERE posta = '$posta'";
		if($ema=mysqli_query($link, $sql)){
			$dago=mysqli_num_rows($ema);
			mysqli_close($link); // Konexioa itxi
			if($dago==0){ // ez bada existitzen horrelako erabiltzailerik anonimoen layout-era joan.
				echo "<script> alert('Erabiltzailea ez dago erregistratuta') </script>";
				echo "<script> window.location.assign('layout.php');</script>"; 
			}
			mysqli_free_result($ema);
		}
	}
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	if(isset($posta) && empty($posta)){
		echo "Berrigorrezko eremu guztiak bete";
		exit();
	} elseif (empty($_POST['eZuzen']) || empty($_POST['eOker1']) || empty($_POST['eOker2']) || empty($_POST['eOker3']) || empty($_POST['zailtasun']) || empty($_POST['gaiarloa'])){
		echo "Berrigorrezko eremu guztiak bete";
		exit();
	}
	else {
	
		if(strlen($_POST['testua'])<9){
			echo "Galderaren testu motzegia";
		}  
		else{		
			// Balio egokiak sartu badira XML fitxategia kargatu.
			$xml = simplexml_load_file('../xml/questions.xml'); 
		
			$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
			if (mysqli_connect_errno()){
				echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
				exit();
			}
				
			$onartuak = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			if(in_array($_FILES['argazkia']['type'], $onartuak)){ // Argazkia igo dela konprobatzeko
				if($_FILES['argazkia']['size'] > 4000000000){
					echo "Argazki oso handia, ezin da igo, saiatu beste batekin.";
				} else {
					$img_tmp = $_FILES['argazkia']['tmp_name']; // Argazkiaren PATH.
					$mota = $_FILES['argazkia']['type']; // Argazkiaren mota.
					$imgData = mysqli_escape_string($link, file_get_contents($img_tmp));
					echo '<script> console.log("Argazkia sartu behar da: '. $imgData . ' mota:' . $mota . '");</script>';
					$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa, argazkia, arg_mota) VALUES ('$posta', '$_POST[testua]', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]','$imgData', '$mota')";
					$ema = mysqli_query($link, $sql);
					if(!$ema){
						echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
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
				}
			} else { // Argazkia ez bada sartzen
				echo '<script> console.log("Argazkia ez da sartu.");</script>';
				$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa) VALUES ('$posta', '$_POST[testua]', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]')";
					
				$ema = mysqli_query($link, $sql);
				if(!$ema){
					echo "Errorea query-a gauzatzerakoan: " . mysqli_error($link);
				}else {
					$nquestion = $xml->addChild('assessmentItem');
					$nquestion->addAttribute('complexity', $_POST['zailtasun']);
					$nquestion->addAttribute('subject', $_POST['gaiarloa']);
					$text = $nquestion->addChild('itemBody');
					$text->addChild('p', $_POST['testua']);
					$qC = $nquestion->addChild('correctResponse');
					$qC->addChild('value',$_POST['eZuzen']);
					$qIs = $nquestion->addChild('incorrectResponses');
					$qIs->addChild('value', $_POST['eOker1']);
					$qIs->addChild('value', $_POST['eOker2']);
					$qIs->addChild('value', $_POST['eOker3']);
					$xml->asXML('../xml/questions.xml'); // Aldaketak XML fitxategian gorde
					echo  "<br><p> Ondo txertatu da DB-an eta XML-ean.</p>";
				}
			} 
			mysqli_close($link); // Konexioa itxi
		}
	}
?>