<?php
$irteera= "Pasahitz baliozkoa";
sleep(2);
$pasahitza=$_GET['pass'];
$badago=false;
$ireki=fopen("../txt/toppasswords.txt","r") or die ("Error - Ezin izan da artxiboa ireki");
while ($lerroa=fgets($ireki)){
	if (strstr($lerroa,$pasahitza)){
		$irteera= "Pasahitza oso ahula";
		$badago=true;
	}
}
echo $irteera;
fclose($ireki);
?>