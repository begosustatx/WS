<?php

 $email=$_GET['email'];

//nusoap.php klasea gehitzen dugu
require_once('/lib/nusoap.php');
require_once('/lib/class.wsdlcache.php');

//soapclient motadun objektua sortzen dugu. 
//erabiliko den SOAP zerbitzuanon dagoen zehazten url horrek
$soapclient = new nusoap_client('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl',false);

//Web-Service-n inplementatu dugun funtzioari dei egiten diogu
//eta itzultzen diguna inprimatzen dugu
$result = $soapclient->call('egiaztatuE', $email);

// print_r($result);
// echo $result;
echo '<br>';
echo "WS ikasgaian " . $result ." zaude matrikulatuta.";
?>