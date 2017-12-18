<?php include 'segurtasuna.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Quizzes</title>
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
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
	  <div class="right">
		  <span><a href="../php/login.php">LogIn</a> </span>
		  <span><a href="../php/signUp.php">SingUp</a> </span>
		  <span>Anonymous</span>
	  </div>
	<h2>Quiz: crazy questions</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='../php/layout.php'>Home</a></span>
		<span><a href='../php/quizzes.php'>Quizzes</a></span>
		<span><a href='../php/credits.php'>Credits</a></span>
	</nav>
<?php
	segurtasunaAnonimo();
	
	$gaia = $_GET['subject'];
	if(($gaia)=='Select a subject'){ 
		echo "<script> alert('Aukeraren bat aukeratu behar duzu ');</script>";
		echo "<script> window.location.assign('quizesbysubject.php');</script>";
	}
	else{
	
		include "dbconfig.php"; 
		$link = mysqli_connect($server, $user, $pass, $db) or die ("Error while connecting to data base.");
		$puntuazioa = $_GET['puntuazioa'];
		//Aurreko galderan (egon bada) erantzun zuzena aukeratu bada, puntuazioari bat gehituko diogu
		if($puntuazioa==1){
			$link = mysqli_connect($server, $user, $pass, $db) or die ("Error while connecting to data base.");
			$nick=$_SESSION['nick'];
			$_SESSION['zuzenak'] = $_SESSION['zuzenak'] + 1;
			$sql="UPDATE anonimoak SET puntuazioa=puntuazioa+1 WHERE nick='$nick'";
			$result=mysqli_query($link, $sql);
			if(!($result))
				echo "Error in the query" . $result->error;
		}
		
		//Galdera guztien id-ak lortu eta array batean sartuko ditugu
		$sql="SELECT ID FROM questions WHERE gaiarloa='$gaia'";
		$result=mysqli_query($link, $sql);
		
		
		if(!($result)){
			echo "Error in the query" . $result->error;
		} else {
			$rows_cont = $result->num_rows;
			if($rows_cont==0){
				echo "<script> alert('Ez dago galderarik');</script>";}
			else{
				
				$idak=array();
				if($rows_cont>0){
					while ($row = $result->fetch_assoc()) {
						array_push($idak, $row['ID']);
						
					}
				}
				//Galderen id-ak aleatorioki ordenatu
				shuffle($idak);
				$id=$idak[0];
				$nick=$_SESSION['nick'];
			
				if (empty($_SESSION['galderak'.$nick])) {
					$_SESSION['galderak'.$nick] = array();
				}
				
				//Konprobatu galdera guztiak erantzun ditugun $_SESSION['galderak'.$nick] egindako galderen id-ak gordetzen goaz 
				else if(count($_SESSION['galderak'.$nick])==3){
					echo "<script> alert('Galdera guztiak erantzun dituzu');
							window.location.assign('finished.php?puntuazioa=0');</script>";
				} else if(count($_SESSION['galderak'.$nick])==count($idak)){
					echo "<script> alert('Galdera guztiak erantzun dituzu');
							window.location.assign('finished.php?puntuazioa=0');</script>";
				}else{
					
					$i=0;
					$bukatu=false;
					//Oraindik erantzun ez dugun galderaren id-a bilatzen dugu
					while(in_array($id, $_SESSION['galderak'.$nick]) and $i<count($idak)){
						$id=$idak[$i];
						$i=$i+1;
					}
				}
				//Erantzungo dugun galderaren id-a gordekoa dugu
				array_push($_SESSION['galderak'.$nick], $id);
				
				//Galdera hori datu basera eskatu
				$sql="SELECT * FROM questions WHERE ID='$id'";
				$result=mysqli_query($link, $sql);
				$row = mysqli_fetch_array($result);
				$rows_cont = $result->num_rows;
				if($rows_cont==0){
					echo "<script> alert('Ez dago id horretako galderarik');</script>";}
				else{
					$galdera=$row['testua'];
					$eZuzen=$row['eZuzen'];
					//Erantzun guztiak array batean gorde eta aleatorioki ordenatu
					$erantzunak=array(0=>$row['eZuzen'],1=>$row['eOker1'],2=>$row['eOker2'],3=>$row['eOker3']);
					shuffle($erantzunak); 
					//Argazkia duen ikusi, erakusteko ala ez
					if($row['argazkia']==NULL)
						$argazkia=false;
					else
						$argazkia=$row['argazkia'];
						$argazkimota=$row['arg_mota'];
				}
			}
		}
	}
	?>

	<script type="text/javascript">
	function konprobatu(){
		var elementuak=document.getElementsByName('erantzuna');
		var luz=elementuak.length;
		var erantzuna='<?php echo $eZuzen;?>';
		var aurkitua=false;
		var i =0;
		var puntuazioa=0;
		
		//Aukeratu dugun erantzuna bilatu 
		while( i<luz && !aurkitua){
			if(elementuak[i].checked)
				aurkitua=true;
			else i++;
		}
		if(aurkitua==false){
			alert('Erantzunen bat aukeratu');
		}
		else{
			eran=elementuak[i].value;
			if(eran==erantzuna){
					puntuazioa = 1;
					//Hurrengo orrialdean puntuazioa gehituko diogu
					window.location.assign('playbysubject.php?puntuazioa=1&subject=<?php echo $gaia;?>');
			} else {
				
					window.location.assign('playbysubject.php?puntuazioa=0&subject=<?php echo $gaia;?>');
				
			}
			
			
		}
		
    } 
		
</script>    
	<section class="main" id="s1">
		<form id="galderaF" name="galderenF" method="post" enctype="multipart/form-data">

		<?php if($argazkia!=false){ ?>
			<img src="data:<?php echo $argazkimota;?>;base64,<?php echo base64_encode($argazkia);?>" width="100px" height="100px" />
		<?php } ?>
			<p><?php echo $galdera;?></p>
			<input type="radio" id="erantzuna" name="erantzuna" value=<?php echo $erantzunak[0];?> /><?php echo $erantzunak[0];?> <br>
			<input type="radio" id="erantzuna" name="erantzuna" value=<?php echo $erantzunak[1];?> /><?php echo $erantzunak[1];?> <br>
			<input type="radio" id="erantzuna" name="erantzuna" value=<?php echo $erantzunak[2];?> /><?php echo $erantzunak[2];?> <br>
			<input type="radio" id="erantzuna" name="erantzuna" value=<?php echo $erantzunak[3];?> /><?php echo $erantzunak[3];?> <br><br>
			
			<input type="button" id="bidali" name="bidali" onclick="javascript:konprobatu()" value="Bidali"/>
			<a href="quizzes2.php?puntuazioa=0'">
				<img src="../img/back.png" style="width:42px;height:42px;border:0;">
			</a>


			</form>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com/begosustatx/WS'>Link GITHUB</a>
	</footer>


</div>

</body>
</html>