<?php
use MoS\LAN\Controller\FrontController;
use PHPRouter\RouteCollection;
use PHPRouter\Config;
use PHPRouter\Router;
use PHPRouter\Route;

// Enable error reporting for testing
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'true');

// Enable Autoloader
require_once __DIR__."/vendor/Psr4AutoloaderClass.php";
$autoloader = new Psr4AutoloaderClass;
$autoloader->register();
$autoloader->addNamespace('MoS\LAN', __DIR__.'/vendor/MoS-LAN/src');
$autoloader->addNamespace('PHPRouter', __DIR__.'/vendor/PHPRouter/src');
$autoloader->addNamespace('Symfony\Component\Yaml', __DIR__.'/vendor/Symfony-YAML');
$autoloader->addNamespace('Fig\Http\Message', __DIR__.'/vendor/http-message-util-master/src');

// Load router configuration
$config = Config::loadFromFile(__DIR__.'/config/routes.yaml');
$router = Router::parseConfig($config);

// Match request
if (!$router->matchCurrentRequest()) {
	// Could not find route, add header
	header("HTTP/1.1 404 Not Found", true, 404);
	// Route to error controller
	if (!$router->match('/error/404')) {
		// No route found to error controller. Include backup document
		include __DIR__.'/error/404.php';
	}
	die();
}

die();










// ---- Old stuff -----

// include routes configuration
//include 'config/routes.php';

$request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

$response = new Response('HTTP/1.0');

$routes = array();
$routes[] = new Route('/', "PageController");
$routes[] = new Route('error', 'ErrorController');
$routes[] = new Route('/test/', 'PageController');
 
$router = new Router($routes);
 
$dispatcher = new Dispatcher;
 
$frontController = new FrontController($router, $dispatcher);
 
$frontController->run($request, $response);

die();

// Init Front Controller
$frontController = new FrontController();
$frontController->run();

die();

// ---- Old stuff ----
	
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