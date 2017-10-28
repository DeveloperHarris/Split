<?php 
require("lib.php");
$endpoint = 'https://sandbox-api.gpsrv.com/intserv/4.0/createAdjustment';
$params = array('apiLogin'=>'yvK6Vd-9999',
	'apiTransKey'=>'AEYqF2DrAv',
	'providerId'=>'432',
	'transactionId'=> rand(0, 100),
	'accountNo'=>'999900030126',
	'amount'=>'25.50',
	'type'=>'F',
	'debitCreditIndicator'=>'D');

$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
curl_setopt($curl, CURLOPT_URL, $endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSLCERT, __dir__ . '\\galileo93.pem');


$result = curl_exec($curl);
curl_close($curl);
$xml = new SimpleXMLElement($result);
$statusCode = (string) $xml->status_code;
print_r($xml);

?>