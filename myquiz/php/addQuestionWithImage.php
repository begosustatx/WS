<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Add Question</title>
    <link rel='stylesheet' type='text/css' href='../stylesPWS/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../stylesPWS/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../stylesPWS/smartphone.css' />
   
   <script src="../js/jquery.min.js"></script>
   <script>
	$(document).ready(function(){
		/* Reseteatu irudia */
			$("#reset").click(function(){
				$("#ikusiarg").removeAttr("src");
			});
			/* Zailtasunaren zenbakia (balioa) ikuskatzeko funtzioa*/
			$("#zailtasun").change(function(){
				console.log("zailtasuna aldatu da");
				var zailZenb = $("#zailtasun").val();
				console.log("zenbakia: " + zailZenb);
				$("#zailZenb").text(" " + zailZenb);
			});
			
			/* Irudia kargatzen bada erakutsi pantailan */
			$("#argazkia").change(function(e){
				console.log("argazkia aldatu da.");
				var img = e.target.files[0], imageType = /image.*/;
				if (!img.type.match(imageType))
					return false;
				var reader = new FileReader();
				reader.onload = fileOnload;
				reader.readAsDataURL(img);
				
				function fileOnload(e) {
					var result=e.target.result;
					$("#ikusiarg").attr("src",e.target.result);
				}
			});
	});
   </script>
   </head>
   
   <body>
   <?php
		//session_start();
		include 'dbconfig.php';
		require_once('segurtasuna.php');
		
		$posta=$_SESSION['mail'];
		$posta = test_input($posta);
		
		if(!isset($posta) && empty($posta))
			echo "<script> window.location.assign('../html/layout.html');</script>";
		// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
		segurtasunaIkaslea();
		// Konprobatu erabiltzailea datu basean dagoen.
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$sql="SELECT * FROM erabiltzaileak WHERE posta = '$posta'";
		if($ema=mysqli_query($link, $sql)){
			$dago=mysqli_num_rows($ema);
			mysqli_close($link); // Konexioa itxi
			if($dago==0){ // ez bada existitzen horrelako erabiltzailerik anonimoen layout-era joan.
				echo "<script> alert('Erabiltzailea ez dago erregistratuta') </script>";
				echo "<script> window.location.assign('../html/layout.html');</script>"; 
			}
			mysqli_free_result($ema);
		}
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	?>
		<div id='page-wrap'>
		<header class='main' id='h1'>
			<div class="right">
				<span><a href="logOut.php">LogOut</a> </span>
				<span> Hello <?php echo $posta; ?> :)</span>
			</div>
			<h2>Quiz: crazy questions</h2>
		</header>
		<nav class='main' id='n1' role='navigation'>
			<span><a href='layoutR.php'>Home</a></span>
			<span><a href='/quizzes'>Quizzes</a></span>
			<span><a href='handlingQuizes.php'>Handle a Quizz</a></span>
			<span><a href='addQuestionWithImage.php'>Add Question</a></span>
			<span><a href='showQuestionsWithImages.php'>Show Questions</a></span>
			<span><a href='creditsR.php'>Credits</a></span>
		</nav>
		<section class="main" id="s1">
			<form id="galderaF" name="galderenF" method="post" enctype="multipart/form-data">
				<p>Posta:</p>
				<?php echo $posta;?>
				<p>Galderaren testua:</p>
				<input type="text" id="testua" name="testua"  />
				<p>Erantzun zuzen bat</p>
				<input type="text" id="eZuzen" name="eZuzen"  />
				<p>Erantzun okerra bat</p>
				<input type="text" id="eOker1" name="eOker1"  />
				<p>Beste erantzun oker bat</p>
				<input type="text" id="eOker2" name="eOker2"  />
				<p>Beste erantzun oker bat</p>
				<input type="text" id="eOker3" name="eOker3"  />
				<p>Galderaren zaitasuna</p>
				<input type="range" name="zailtasun" id="zailtasun" min="1" max="5"  />
				<span id="zailZenb"></span>
				<p>Galderaren gai-arloa</p>
				<input type="text" id="gaiarloa" name="gaiarloa"  />
				<p class="argazkia"><label for="argazkia"> Galderaren irudia: </label>
				<input type="file" id="argazkia" name="argazkia"/>
				</p>
				<img id="ikusiarg" src="" width="300px">
				<br>
				<input type="reset" id="reset" name="reset" value="Reset">
				<input type="submit" id="bidali" name="bidali" value="Bidali"/>
			</form>
	<?php
	include 'dbconfig.php';
	if(isset($_POST['bidali']))
	{	
		if(isset($posta) && empty($posta)){
			echo "<script> alert('Berrigorrezko eremu guztiak bete')</script>";
			exit();
		} elseif (empty($_POST['eZuzen']) || empty($_POST['eOker1']) || empty($_POST['eOker2']) || empty($_POST['eOker3']) || empty($_POST['zailtasun']) || empty($_POST['gaiarloa'])){
			echo "<script> alert('Berrigorrezko eremu guztiak bete')</script>";
			exit();
		}	else {
			$patroia='/^[a-z]{2,}[0-9]{3}@ikasle\.ehu\.(eus|es)$/';
			if(!preg_match($patroia,$posta)){
				echo "<script> alert('Posta okerra')</script>";
				exit();
			}
			if(!isset($_POST['testua'])){
				echo "<script> alert('Berrigorrezko eremu guztiak bete')</script>";
				exit();
			} else {
				$testua= $_POST['testua'];
				if(strlen($testua)<9){
					echo "<script> alert('Galderaren testu motzegia')</script>";
					exit();
				}  
			}
		} 
		
		// Balio egokiak sartu badira XML fitxategia kargatu.
		$xml = simplexml_load_file('../xml/questions.xml'); 
	
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		if (mysqli_connect_errno()){
			echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
			exit();
		}
			
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
				$xml->asXML('../xml/questionsTransAuto.xml'); // Aldaketak XML fitxategian gorde
				echo  "<br><p> Ondo txertatu da.</p>";
				//echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='showXMLQuestions.php'>hemen</a></p>" ;
				//echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='../xml/questionsTransAuto.xml'>hemen</a></p>" ;
				// echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='showXMLQuestions.php'>hemen</a></p>" ;
				ondoTxertatua();
			}
		} else { // Argazkia ez bada sartzen
			$sql="INSERT INTO questions(posta, testua, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaiarloa) VALUES ('$posta', '$testua', '$_POST[eZuzen]', '$_POST[eOker1]', '$_POST[eOker2]', '$_POST[eOker3]', '$_POST[zailtasun]', '$_POST[gaiarloa]')";
				
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
				$xml->asXML('../xml/questionsTransAuto.xml'); // Aldaketak XML fitxategian gorde
				// echo  "<br><p> Ondo txertatu da.</p>";
				// echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='showXMLQuestions.php'>hemen</a></p>" ;
				// echo  "<p> Galdera guztiak ikusi ditzazkezu <a href='../xml/questionsTransAuto.xml'>hemen</a></p>" ;
				// echo  "<p> Galdera guztiak ikusi ditzazkezu taula moduan <a href='showXMLQuestions.php'>hemen</a></p>" ;
				ondoTxertatua();
			}
		}
		mysqli_close($link); // Konexioa itxi
	}
	function ondoTxertatua(){
		echo "<script>
					if (window.confirm('Ondo txertatu da. Galdera guztiak taula moduan ikusi nahi dituzu?') == true) {
						window.location.assign('showXMLQuestions.php');
					}
			</script>";
	}
	
	?>
		</section>
		<footer class='main' id='f1'>
			<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
			<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
		</footer>
		
 

 </body>
</html>