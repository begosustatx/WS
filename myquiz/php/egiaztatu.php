<?php
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');
$ns="http://localhost:1234/WS/myquiz/php/egiaztatu.php?wsdl";
$server = new soap_server;
$server->configureWSDL('egiaztatu',$ns);
$server->wsdl->schemaTargetNamespace=$ns;
/*
$server->soap_defencoding='utf-8';
$server->encode_utf8 = false;
$server->decode_utf8 = false;*/
$server->register ('egiaztatu', array('x'=>'xsd:string'), array('z'=>'xsd:string'),$ns);
function egiaztatu($pasahitza) {
	$emaitza="BALIOZKOA";
	$badago=false;
	$ireki=fopen("../txt/toppasswords.txt","r") or die ("Error - Ezin izan da artxiboa ireki");
	while ($lerroa=fgets($ireki) and !$badago){
		if (strstr($lerroa,$pasahitza)){
			$emaitza="BALIOGABEA";
			$badago=true;
		}
	}
	fclose($ireki);
	return ($emaitza);
}
//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service(file_get_contents('php://input'));
?>