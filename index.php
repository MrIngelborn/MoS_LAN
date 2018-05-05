<?php
use MoS\LAN\FrontController;

// Enable error reporting for testing
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'true');

require_once __DIR__.'/bootstrap.php';

$controller = new FrontController($twig, $router, $db);
$controller->handleRequest();

?>