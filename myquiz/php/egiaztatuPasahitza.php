<?php

$email=$_GET['email'];

//nusoap.php klasea gehitzen dugu
require once('../lib/nusoap.php');
require_once('../lib/class.wsdlcache.php');

//soapclient motadun objektua sortzen dugu. 
//erabiliko den SOAP zerbitzuanon dagoen zehazten url horrek
$soapclient = new nusoap_client('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl',true);

//Web-Service-n inplementatu dugun funtzioari dei egiten diogu
//eta itzultzen diguna inprimatzen dugu
$result = $soapclient->call('egiaztatuE');

print_r($result);
echo '<br>';
echo '<b>EUROCOPA 2016:</b> <br>';
echo 'Txartel Horiak:' . $result['YellowAndRedCardsTotalResult']['iYellow'];
echo '<br>';
echo 'Txartel Gorriak:' . $result['YellowAndRedCardsTotalResult']['iRed'];
?>