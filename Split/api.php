<?php
	require("database.php");
	require("lib.php");
	$db = new Database();
	switch($_POST['function'])
	{
		case "add_user_prn":
			add_user_prn();
			break;
		case "create_action":
			create_action();
			break;
		case "get_galileo_accounts":
			get_galileo_accounts();
			break;
		case "set_account_name":
			set_account_name();
			break;
		case "get_main_user":
			get_main_user();
			break;
		case "store_account":
			store_account();
			break;
		case "add_account":
			add_account();
			break;
		case "get_accounts":
			get_saved_accounts();
			break;
		case "get_account_info":
			get_account_info();
			break;
		case "update_account_info":
			update_account_info();
			break;
	}
	function create_action()
	{
		$transId = generateTransactionId();
		$endpoint = 'https://sandbox-api.gpsrv.com/intserv/4.0/createAccount';
		$params = array('apiLogin'=>'yvK6Vd-9999',
			'apiTransKey'=>'AEYqF2DrAv',
			'providerId'=>'432',
			'transactionId'=> $transId,
			'prodId'=>'5094',
			'firstName' => $_POST['first_name'],
			'lastName' => $_POST['last_name'],
			'middleName' => $_POST['middle_name'],
			'dateOfBirth' => $_POST['DOB'],
			'address1' => $_POST['addr1'],
			'address2' => $_POST['addr2'],
			'city' => $_POST['city'],
			'state' => $_POST['state'],
			'postalCode' => $_POST['zip'],
			'countryCode' => $_POST['country_code'],
			'expressMail' => $_POST['express_mail'],
			'primaryPhone' => $_POST['phone'],
			'email' => $_POST['email'],
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
		echo json_encode(new SimpleXMLElement($result));
		
	}
	function set_account_name()
	{
		$sql = "INSERT INTO account_names (user_id, galileo_id, account_name) VALUES (";
		$sql .= "'" . $_POST['user_id'] . "', '" . $_POST['galileo_id'] . "', '" . $_POST['account_name'] . "')";
		$db->query($sql);
	}
	function get_galileo_accounts()
	{
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
	}
	function add_user_prn()
	{
		global $db;
		print_r($_POST);
		$sql = "UPDATE users SET galileo_PRN='" . $_POST['prn'] . "' WHERE id='" . $_POST['user_id'] . "';";
		$db->query($sql);
		print_r($db->getError());
	}
	function get_saved_accounts()
	{
		global $db;
		$sql = "SELECT * FROM account_names WHERE user_id='" . $_POST['user_id'] . "';";
		$result = $db->query($sql);
		echo json_encode($result->fetch_assoc());
	}
	function get_main_user()
	{
		global $db;
		$sql = "SELECT id, email, first_name, last_name, galileo_PRN from users WHERE email='" . $_POST['id'] . "';";
		$result = $db->query($sql);
		echo json_encode($result->fetch_assoc());
	}
	function add_account()
	{
		global $db;
		$transId = generateTransactionId();
		$endpoint = "https://sandbox-api.gpsrv.com/intserv/4.0/addAccount";
		$params = array('apiLogin'=>'yvK6Vd-9999',
			'apiTransKey'=>'AEYqF2DrAv',
			'providerId'=>'432',
			'transactionId'=>$transId,
			'accountNo'=>'999900032718',
			'prodId'=>'5094'
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
		$sql = "INSERT INTO account_names (user_id, galileo_id, account_name, color) VALUES (";
		$sql .= "'" . $_POST['userId'] . "', '" . $xml->response_data->new_account->pmt_ref_no . "', 'New Account', 'blue')";
		print_r($xml);
		$db->query($sql);
		echo $sql;
		echo $db->getError();
	}
	function store_account()
	{
		global $db;
		$sql = "INSERT INTO account_names (user_id, galileo_id, account_name, color) VALUES (";
		$sql .= "'" . $_POST['userId'] . "', '" . $_POST['prn'] . "', '" . $_POST['name'] . "', '" . $_POST['color'] . "')";
		$db->query($sql);
		echo $sql;
		echo $db->getError();
	}
	function get_account_info()
	{
		$transId = generateTransactionId();
		$endpoint = 'https://sandbox-api.gpsrv.com/intserv/4.0/verifyAccount';
		$params = array('apiLogin'=>'yvK6Vd-9999',
			'apiTransKey'=>'AEYqF2DrAv',
			'providerId'=>'432',
			'transactionId'=>$transId,
			'accountNo'=> $_POST['prn']);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_URL, $endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSLCERT, __dir__ . '\\galileo93.pem');

		$result = curl_exec($curl);
		curl_close($curl);
		$xml = new SimpleXMLElement($result);
		echo json_encode($xml);
	}
	function update_account_info()
	{
		global $db;
		$sql = "UPDATE account_names SET account_name='" . $_POST['name'] . "', monthly_balance='" . $_POST['monthly_balance'] . "' WHERE galileo_id='" . $_POST['id'] . "';";
		$db->query($sql);
		echo $sql;
		echo $db->getError();
	}
?>