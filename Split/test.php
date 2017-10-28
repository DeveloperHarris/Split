<?php
require("lib.php");

$endpoint = 'https://sandbox-api.gpsrv.com/intserv/4.0/createPayment';
$params = array('apiLogin'=>'yvK6Vd-9999',
	'apiTransKey'=>'AEYqF2DrAv',
	'providerId'=>'432',
	'transactionId'=> generateTransactionId(),
	'accountNo'=>'999900030126',
	'amount'=>'25.50',
	'type'=>'RL',
	'locationType'=>'1');

$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
curl_setopt($curl, CURLOPT_URL, $endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSLCERT, __dir__ . '\\galileo93.pem');

$result = curl_exec($curl);
print_r($result);
curl_close($curl);
$xml = new SimpleXMLElement($result);
print_r($xml);
$statusCode = (string) $xml->status_code;
//echo "method response status code={$statusCode}";

?>