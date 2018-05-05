<?php
use MoS\LAN\Helpers\PDOFactory;

// Enable error reporting for testing
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'true');

// Setup autoloader
require_once __DIR__."/vendor/Psr4AutoloaderClass.php";
$autoloader = new Psr4AutoloaderClass;
$autoloader->register();
$autoloader->addNamespace('MoS\LAN',                __DIR__.'/app/src');
$autoloader->addNamespace('Symfony\Component\Yaml', __DIR__.'/vendor/Symfony-YAML');

$db = PDOFactory::createFromYamlConfig(__DIR__.'/config/db.yaml');

?>