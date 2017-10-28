<?php

$endpoint = 'https://sandbox-api.gpsrv.com/intserv/4.0/ping';
$params = array('apiLogin'=>'yvK6Vd-9999','apiTransKey'=>'AEYqF2DrAv','providerId'=>'432','transactionId'=>'47531-random-string-90194');
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
curl_setopt($curl, CURLOPT_URL, $endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSLCERT, __dir__ . '\\galileo93.pem');

$result = curl_exec($curl);

if (false === $result) {
    echo "Curl Error : " . curl_error($curl);
    curl_close($curl);
    die();
}

curl_close($curl);
$xml = new SimpleXMLElement($result);
$statusCode = (string) $xml->status_code;
echo "method response status code={$statusCode}";
?>