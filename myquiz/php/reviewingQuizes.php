<?php include 'segurtasuna.php';?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Reviewing Quizes</title>
    <link rel='stylesheet' type='text/css' href='../stylesPWS/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='../stylesPWS/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='../stylesPWS/smartphone.css' />
	<style>
		table {border-collapse: collapse;}
		th {background-color:#b3daff;}
		tr:hover {background-color: #ffffff;}
		td {padding: 10px;}
		#aldatu {text-align: center;}
		#galderak {padding: 20px; display: none; text-align: center;}
		#aukeratua {padding: 20px; display: none; text-align: center;}
	</style>
	<script src="../js/jquery-3.2.1.js"></script>
	<script>
		$(document).ready(function(){
			xhro = new XMLHttpRequest();
			$('tr').click(function(){
				//alert("Taula clickatua.");
				$('#galderak').slideDown();
				$('body, html').animate({scrollTop: '0px'}, "slow");
			});
			$('#aldatu').click(function(){
				$('#galderak').slideToggle();
			});
			$('#testua').change(function(){
				var testua = $('#testua').val();
				xhro.open("GET","galderaErakutsi.php?testua="+testua, true);			
				xhro.send();					
			});
			xhro.onreadystatechange = function(){
				if ((xhro.readyState==4)&&(xhro.status==200 )){ 
					document.getElementById("aukeratua").innerHTML= xhro.responseText + "<input type='submit' name='aldatuB' value='Aldatu'/> <input type='submit' name='ezabatuB' value='Ezabatu'/>";
					$("#aukeratua").slideDown();
				}
			}
			
		});
	</script>
  </head>
  
  <body>
	<?php 

		if(!(isset($_SESSION['mail'])) && empty($_SESSION['mail']))
			echo "<script> window.location.assign('../html/layout.html');</script>";
		$email=$_SESSION['mail'];
		// Irakaslea dela konprobatu.
		segurtasunaIrakaslea();
		
		include 'dbconfig.php';
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		$sql="SELECT * FROM erabiltzaileak WHERE posta = '$email'";
		if($ema=mysqli_query($link, $sql)){
			$dago=mysqli_num_rows($ema);
			mysqli_close($link); // Konexioa itxi
			if($dago==0) // ez bada existitzen horrelako erabiltzailerik anonimoen layout-era joan.
				echo "<script> window.location.assign('../html/layout.html');</script>"; 
			mysqli_free_result($ema);
		}	
	?>
	<header class='main' id='h1'>
	<div class="right">
      <span><a href="logOut.php">LogOut</a> </span>
	  <span> Hello <?php echo $email; ?> :)</span>
	</div>
	<h2>Quiz: crazy questions</h2>
	</header>
	<a href="layout.php">
		<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>
	<div id="aldatu" name="aldatu">▼ Aldatu galderak ▼ </div>
	<div id="galderak" name="galderak">
	<?php
		include 'dbconfig.php';
		$link = mysqli_connect($server, $user, $pass, $db); // Konexioa ireki
		if (mysqli_connect_errno()){
			echo "Konexio hutxegitea MySQLra: " . mysqli_connect_error();
			exit();
		}
		
		// Zein galdera aldatu nahi den aukeratzeko.
		$testua=mysqli_query($link, "select * from questions");
				echo '<select id="testua" name="testua">';
				echo '<option>Aukeratu galdera bat</option>';
		while ($row = mysqli_fetch_array($testua)){
			echo '<option>'. $row['testua'] . '</option>';
		}
	?>
		</select>
		<!-- Hemen aukeratutako galderaren parametro guztiak agertuko dira. -->
		<form id="aukeratua" method="post" enctype="multipart/form-data" action="aktualizatu.php">
		</form>
		</div>
	<?php
		// Galdera guztien taula:
		$galderak=mysqli_query($link, "select * from questions");
		echo '<div style="overflow-x:auto;">';
		echo '<table border=1><tr><th> Posta </th><th> Testua </th><th> Erantzun zuzena </th><th> Erantzun okerra 1 </th><th> Erantzun okerra 2 </th><th> Erantzun okerra 3 </th><th> Zailtasuna </th><th> Gaiarloa </th> <th> Argazkia </th></tr>';
		while($row = mysqli_fetch_array($galderak)){
			if($row['argazkia']==NULL){
				echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td> <img src="../img/default.jpg" width="300px" height="300px" /></td></tr>';
			} else
				echo '<tr><td>' . $row['posta'] . '</td><td>' . $row['testua'] . '</td><td>' . $row['eZuzen'] . '</td><td>' . $row['eOker1'] . '</td><td>' . $row['eOker2'] . '</td><td>' . $row['eOker3'] . '</td><td>' . $row['zailtasun'] . '</td><td>' . $row['gaiarloa'] . '</td><td> <img src="data:' . $row['arg_mota'] . ';base64,' . base64_encode($row['argazkia']) . '" width="300px" height="300px" /></td></tr>';
		}	
		echo '</table></div>';
		mysqli_close($link); // Konexioa itxi
	?>
	<a href="layout.php">
		<img src="../img/back.png" style="width:42px;height:42px;border:0;">
	</a>
  </body>