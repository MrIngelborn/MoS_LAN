<?php
use MoS\LAN\FrontController,
    MoS\LAN\Helpers\PDOFactory,
    Bramus\Router\Router;;

// Enable error reporting for testing
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'true');

// Setup my autoloader
require_once __DIR__."/app/Psr4AutoloaderClass.php";
$autoloader = new Psr4AutoloaderClass;
$autoloader->register();
$autoloader->addNamespace('MoS\LAN', __DIR__.'/app/src');
//$autoloader->addNamespace('MoS\LAN', __DIR__.'/app/test');

// Load conposers autoloader
require_once __DIR__.'/vendor/autoload.php';

// Specify Twig templates location
$loader = new Twig_Loader_Filesystem(__DIR__.'/app/src/Templates');

// Instantiate Twig
$twig = new Twig_Environment($loader);

// Create database connection
$pdo = PDOFactory::createFromYamlConfig(__DIR__.'/app/config/db.yaml');

// Create Router instance
$router = new Router();

// Create FrontController and handle request
$controller = new FrontController($twig, $router, $pdo);
$controller->handleRequest();

?>