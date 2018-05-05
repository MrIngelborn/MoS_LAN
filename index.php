<?php
use MoS\LAN\Helpers\PDOFactory;

// Enable error reporting for testing
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'true');

require_once __DIR__.'/bootstrap.php';

$db = PDOFactory::createFromYamlConfig(__DIR__.'/config/db.yaml');

?>