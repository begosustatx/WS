<?php
//nusoap.php klasea gehitzen dugu
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');
//soapclient motadun objektua sortzen dugu. 
//erabiliko den SOAP zerbitzuanon dagoen zehazten url horrek
$soapclient = new nusoap_client('http://localhost:1234/WS/myquiz/php/egiaztatu.php?wsdl',true);
$pass=$_GET['pass'];
//Web-Service-n inplementatu dugun funtzioari dei egiten diogu
//eta itzultzen diguna inprimatzen dugu
$result = $soapclient->call('egiaztatu', array('x'=>$pass));
$error = $soapclient->getError();
if ($error) {
    echo "<h2>Error</h2><pre>" . $error . "</pre>";
}
else {
    echo $result;
}
?>