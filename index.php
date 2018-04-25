<?php
use MoS\LAN\Autoloader;

// Enable error reporting for testing
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'true');

// Enable Autoloader
require_once __DIR__."/classes/Autoloader.php";
$autoloader = new Autoloader();
$autoloader->register();

die();
	
// Always update activity
require('functions/update_activity.php');

/* User portal, requires login */
require('functions/is_logged_in.php');
$is_admin = $_SESSION['admin'];


?>


<html>
	<head>
		<title>MoS LAN System</title>
	</head>
	<body>
		<h1>User portal</h1>
		
		
	</body>
</html>