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
   </head>
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
<script type="text/javascript" language = "javascript">

		function galderakIkusi(){
			var xhro = new  XMLHttpRequest;
			var testua=document.getElementById('testua').value;
			var gaiarloa=document.getElementById('gaiarloa').value;
			var zailtasun=document.getElementById('zailtasun').value;
			var eZuzen=document.getElementById('eZuzen').value;
			var eOker1=document.getElementById('eOker1').value;
			var eOker2=document.getElementById('eOker2').value;
			var eOker3=document.getElementById('eOker3').value;
			ruta="showQuestionsAJAX.php";
			envio1="testua="+testua;
			envio2="gaiarloa="+gaiarloa;
			envio3="zailtasun="+zailtasun;
			envio4="eZuzen="+eZuzen;
			envio5="eOker1="+eOker1;
			envio6="eOker2="+eOker2;
			envio7="eOker3="+eOker3;
			url=ruta+"?"+envio1+"&"+envio2+"&"+envio3+"&"+envio4+"&"+envio5+"&"+envio6+"&"+envio7;
			xhro.onreadystatechange = function(){
				alert(xhro.readyState);
				if ((xhro.readyState==4)&&(xhro.status==200 )){
					document.getElementById("galderakIkusi").innerHTML= xhro.responseText;
				}
			};
			console.log("Funtzioaren barruan");
			xhro.open("GET",url, true);
			xhro.send();
		}
	function galderaGehitu(){
			var xhro = new  XMLHttpRequest;
			var testua=document.getElementById('testua').value;
			var gaiarloa=document.getElementById('gaiarloa').value;
			var zailtasun=document.getElementById('zailtasun').value;
			var eZuzen=document.getElementById('eZuzen').value;
			var eOker1=document.getElementById('eOker1').value;
			var eOker2=document.getElementById('eOker2').value;
			var eOker3=document.getElementById('eOker3').value;
			ruta="addQuestionAJAX.php";
			envio1="testua="+testua;
			envio2="gaiarloa="+gaiarloa;
			envio3="zailtasun="+zailtasun;
			envio4="eZuzen="+eZuzen;
			envio5="eOker1="+eOker1;
			envio6="eOker2="+eOker2;
			envio7="eOker3="+eOker3;
			url=ruta+"?"+envio1+"&"+envio2+"&"+envio3+"&"+envio4+"&"+envio5+"&"+envio6+"&"+envio7;
			xhro.onreadystatechange = function(){
				alert(xhro.readyState);
				if ((xhro.readyState==4)&&(xhro.status==200 )){
					document.getElementById("galderaGehitu").innerHTML= xhro.responseText;
				}
			};
			xhro.open("GET",url, true);
			xhro.send();
	}
</script>
   <?php
		$posta=$_GET['email'];
	?>
   <body>
		<div id='page-wrap'>
		<header class='main' id='h1'>
			<div class="right">
				<span><a href="logOut.php?email=<?php echo $posta; ?>">LogOut</a> </span>
				<span> Hello <?php echo $posta; ?> :)</span>
			</div>
			<h2>Quiz: crazy questions</h2>
		</header>
		<nav class='main' id='n1' role='navigation'>
			<span><a href='layoutR.php?email=<?php echo $posta;?>'>Home</a></span>
			<span><a href='/quizzes'>Quizzes</a></span>
			<span><a href='addQuestionWithImage.php?email=<?php echo $posta;?>'>Handle a Quizz</a></span>
			<span><a href='showQuestionsWithImages.php?email=<?php echo $posta;?>'>Show Questions</a></span>
			<span><a href='creditsR.php?email=<?php echo $posta;?>'>Credits</a></span>
		</nav>
		<section class="main" id="s1">
			<form id="galderaF" name="galderenF" method="post" enctype="multipart/form-data">
				<input type="button" id="gehitu" name="gehitu" value="Galdera gehitu" onclick="galderaGehitu()"/>
				<input type="button" id="ikusi" name="ikusi" value="Galderak ikusi" onclick="galderakIkusi()"/>
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
			</form>
			<div id="galderakIkusi" style="background-color:#99FF66;">
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