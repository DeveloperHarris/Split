<?php 
$endpoint = 'https://sandbox-api.gpsrv.com/intserv/4.0/getAccountById';
$params = array('apiLogin'=>'yvK6Vd-9999',
	'apiTransKey'=>'AEYqF2DrAv',
	'providerId'=>'432',
	'id'=> $_POST['prn'],
	'idType'=>'0');

$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
curl_setopt($curl, CURLOPT_URL, $endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSLCERT, __dir__ . '\\galileo93.pem');

$result = curl_exec($curl);
curl_close($curl);
$xml = new SimpleXMLElement($result);
print_r($xml);



?>