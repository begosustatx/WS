<?php include 'segurtasuna.php';?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Handling Quizes</title>
    <link rel='stylesheet' type='text/css' href='../stylesPWS/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../stylesPWS/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../stylesPWS/smartphone.css' />
   </head>
   <script src="../js/jquery-3.2.1.js"></script>
   <script>
	$(document).ready(function(){
		/* Reseteatu irudia */
			$("#reset").click(function(){
				$("#ikusiarg").removeAttr("src");
				$("#zailZenb").text(" 3");
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
   <!-- Derrigorrezko atalaren script-ak -->
<script type="text/javascript" language = "javascript">
		function galderakIkusi(){
			var xhro = new  XMLHttpRequest;
			var email;
			url="showQuestionsWithImages.php";
			xhro.onreadystatechange = function(){
				console.log("Ikusiren status: "+xhro.readyState);
				if ((xhro.readyState==4)&&(xhro.status==200 )){
					document.getElementById("galderakIkusi").innerHTML= xhro.responseText;
				} else
					document.getElementById("galderakIkusi").innerHTML = "<img src='../img/loading.gif' width=50px>";
			};
			console.log("Ikusi funtzioaren barruan");
			xhro.open("GET",url, true);
			xhro.send();
		}
		function galderaGehitu(){
			var xhro = new  XMLHttpRequest;
			var gaiarloa=document.getElementById('gaiarloa').value;
			var zailtasun=document.getElementById('zailtasun').value;
			var eZuzen=document.getElementById('eZuzen').value;
			var eOker1=document.getElementById('eOker1').value;
			var eOker2=document.getElementById('eOker2').value;
			var eOker3=document.getElementById('eOker3').value;
			var argazkia=document.getElementById('argazkia').value;
			var formData = new FormData();
			ruta="addQuestionAJAX.php";
			formData.append("testua", $('#testua').val());
			formData.append("gaiarloa", $('#gaiarloa').val());
			formData.append("zailtasun", $('#zailtasun').val());
			formData.append("eZuzen", $('#eZuzen').val());
			formData.append("eOker1", $('#eOker1').val());
			formData.append("eOker2", $('#eOker2').val());
			formData.append("eOker3", $('#eOker3').val());
			formData.append("argazkia", $('#argazkia')[0].files[0]);
			/*xhro.onreadystatechange = function(){
				console.log("Gehituren status: "+xhro.readyState);
				if ((xhro.readyState==4)&&(xhro.status==200 )){
					document.getElementById("galderaGehitu").innerHTML= xhro.responseText;
				} else 
					document.getElementById("galderaGehitu").innerHTML = "<img src='../img/loading.gif' width=50px>";
			};
			xhro.open("GET",url, true);
			xhro.send();*/
			$.ajax({
				type: 'POST',
				url: ruta,
				data: formData,
				contentType: false,
				processData: false,
				cache: false,
				success: function(result){
					document.getElementById("galderaGehitu").innerHTML = result;
					// console.log(result);
				},
				error: function(error){
					document.getElementById("galderaGehitu").innerHTML = error;
					// console.log(error);
				},
				beforeSend: function(){
					document.getElementById("galderaGehitu").innerHTML = "<img src='../img/loading.gif' width=50px>";
					console.log('Galdera bidali da.');
				}
			});
	}
	
	/*
	function getVariableFromQuery(variable){
		var query = window.location.search.substring(1);
		var vars = query.split("&");
		// console.log("vars: "+vars);
		if(vars[0].search(variable)<0){
			return false;
		}
		var i = vars[0].search("=");
		// console.log("email position:" + i);
		var pair = vars[0].slice(i+1);
		// console.log("pair: "+pair);
		return pair;
		}*/
		
		function startFunction(){
			// console.log("Hasierako funtzio barruan.");
			setInterval(kopurua, 20000);
		}
		
		function kopurua(){
			var xhro = new  XMLHttpRequest;
			var url = "kontatuGalderakAJAX.php";
			
			xhro.onreadystatechange = function(){
				// console.log("Kopuruaren status: "+xhro.readyState);
				if ((xhro.readyState==4)&&(xhro.status==200 )){
					document.getElementById("galderaKop").innerHTML= xhro.responseText;
				} else 
					document.getElementById("galderaKop").innerHTML = "<img src='../img/loading.gif' width=50px>";
			};
			xhro.open("GET",url, true);
			xhro.send();
		}
</script>
   
   <body>
		<?php
			include 'dbconfig.php';
		
			if(!isset($_SESSION['mail']) && empty($_SESSION['mail'])){
				echo "<script> window.location.assign('layout.php');</script>";
			}else {
				$posta=$_SESSION['mail'];
				$posta = test_input($posta);
			}
			// Konprobatu erabiltzailea ikasle moduan kautotuta dagoela.
			if(segurtasunaIkaslea()==0){
				echo "<script>alert('Ez daukazu hemen egoteko baimenik!\nIrteten...');</script>";
				echo "<script> window.location.assign('layout.php');</script>";
			}

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
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
		?>
		<script>startFunction();</script>
			
		<div id='page-wrap'>
		<header class='main' id='h1'>
			<div class="right">
				<span><a href="logOut.php?email=<?php echo $posta; ?>">LogOut</a> </span>
				<span> Hello <?php echo $posta; ?> :)</span>
			</div>
			<h2>Quiz: crazy questions</h2>
		</header>
		<nav class='main' id='n1' role='navigation'>
			<span><a href='layout.php'>Home</a></span>
			<span><a href='handlingQuizes.php'>Handle a Quizz</a></span>
			<span><a href='credits.php'>Credits</a></span>
			<span><a href='pasahitzaAldatu.php'>Change your password</a></span>
		</nav>
		<section class="main" id="s1">
			Zure galderak /  Galdera guztira
			<br>
			<div id="galderaKop"></div>
			<form id="galderaF" name="galderenF" method="post" enctype="multipart/form-data">
				<p>Posta:</p>
				<span id='email'><?php echo $posta;?></span>
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
				<span id="zailZenb">3</span>
				<p>Galderaren gai-arloa</p>
				<input type="text" id="gaiarloa" name="gaiarloa"  />
				<p class="argazkia"><label for="argazkia"> Galderaren irudia: </label>
				<input type="file" id="argazkia" name="argazkia"/>
				</p>
				<img id="ikusiarg" src="" width="300px">
				<br>
				<input type="reset" id="reset" name="reset" value="Reset">
				<input type="button" id="gehitu" name="gehitu" value="Galdera gehitu" onclick="galderaGehitu()"/>
				<input type="button" id="ikusi" name="ikusi" value="Galderak ikusi" onclick="galderakIkusi()"/>
			</form>
			<div id="galderakIkusi" style="background-color:#99FF66;overflow-x:auto;">
				<p>Galdera guztiak hemen ikusiko dira</p>
			</div>
			<div id="galderaGehitu" style="background-color:#99FF66;">
				<p>Txertaketaren emaitza hemen ikusiko da</p>
			</div>
			
		</section>
		<footer class='main' id='f1'>
			<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
			<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
		</footer>
		
 </body>
</html>