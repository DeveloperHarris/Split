<?php
require("lib.php");
$transId = generateTransactionId();
$endpoint = 'https://sandbox-api.gpsrv.com/intserv/4.0/createAccount';
$params = array('apiLogin'=>'yvK6Vd-9999',
	'apiTransKey'=>'AEYqF2DrAv',
	'providerId'=>'432',
	'transactionId'=> $transId,
	'prodId'=>'5094',
	'firstName' => $_GET['first_name'],
	'lastName' => $_GET['last_name'],
	'middleName' => $_GET['middle_name'],
	'dateOfBirth' => $_GET['DOB'],
	'address1' => $_GET['addr1'],
	'address2' => $_GET['addr2'],
	'city' => $_GET['city'],
	'state' => $_GET['state'],
	'postalCode' => $_GET['zip'],
	'countryCode' => $_GET['country_code'],
	'expressMail' => $_GET['express_mail'],
	'primaryPhone' => $_GET['phone'],
	'email' => $_GET['email'],
	'webUid' => $_GET['web_username'],
	'webPwd' => $_GET['web_pass'],
	'verifyOnly' => '0'
	);

$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
curl_setopt($curl, CURLOPT_URL, $endpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSLCERT, __dir__ . '\\galileo93.pem');

$result = curl_exec($curl);
curl_close($curl);
$xml = new SimpleXMLElement($result);
$necessary_data_array = array(
	"PRN" => $xml->response_data->new_account->pmt_ref_no);
echo json_encode($necessary_data_array);
?>