<?php 
	require("database.php");
	$db = new Database();
	function create_account()
	{
		global $db;
		if ($db->check_email($_POST['email']))
		{
			$db->create_user($_POST['email'], $_POST['password']);
		}
		else
		{
			echo "TEST";
		}
	}
	function login()
	{
		global $db;
		$db->checkUser($_POST['email'], $_POST['password']);
	}
	if ($_GET == array())
	{
		create_account();
	}
	else
	{
		login();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="card.css">
    	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		
    	<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>-->
	</head>
	<body>
		<div class="container"></div>
		<div id="result"></div>
		<button id="button">CLick me!</button>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="js.js"></script>
		<script type="text/js">var mainUserId=<?php echo $_POST['email'] ?></script>
	</body>
</html>