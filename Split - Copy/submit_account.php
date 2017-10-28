<?php
	require("database.php");
	print_r($_POST);
	$db = new Database();
	$sql = "INSERT INTO users (email, password_hash, first_name, last_name) VALUES (";
	$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$sql .= "'" . $_POST['email'] . "', '" . $password_hash . "', '" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "')";
	echo $db->query($sql);
	echo $db->getError();
?>