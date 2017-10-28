<?php 
	require("database.php");
	$db = new Database();
	
	$logged_in = $db->checkUser($_POST['email'], $_POST['password']);
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
	</head>
	<body>
		<div class="container" ng-controller="MainController"></div>
		<div id="result"></div>
		<button id="button">CLick me!</button>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js.js"></script>
	</body>
</html>