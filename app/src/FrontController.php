<?php
namespace MoS\LAN;

use Twig\Environment,
    Bramus\Router\Router,
    MoS\LAN\Controllers,
    MoS\LAN\Views,
    MoS\LAN\Models;

class FrontController
{
	private $twig;
	private $router;
	private $pdo;
	private $controller;
	private $model;
	private $view;
	
	public function __construct(Environment $twig, Router $router, \PDO $pdo)
	{
		$this->twig = $twig;
		$this->router = $router;
		$this->pdo = $pdo;
		$this->setupRoutes();
	}
	public function handleRequest()
	{
		//$this->twigEnvironment->display('index.html');
		$this->router->run(function() {
			if (isset($this->view)) {
				$this->view->display();
			}
		});
	}
	
	private function setupRoutes()
	{
		$this->router->set404(function(){$this->notFound();});
		
		// Default route
		$this->router->before('GET', '/', function() {
			header('Location: /pages/index');
			die();
		});
		
		// Handle file requests
		$this->router->get('/([a-z0-9/]+/)?(\w+)\.(\w+)', function($path, $filename, $ending) {
			// TODO: Handle the requests
			var_dump($path);
			var_dump($filename);
			var_dump($ending);
		});
		
		// Pages
		$this->router->before('GET', '/pages.*', function() {
			$this->controller = new Controllers\PageController($this->pdo, $this->twig);
		});
		$this->router->mount('/pages', function() {
			$this->router->get('/', function() {
				// List Pages
				$this->controller->list();
			});
			$this->router->get('/(\w+)', function($name) {
				// Get page by name
				$this->controller->get($name);
			});
		});
		
		// Users
		$this->router->before('GET|POST|PATCH|DELETE', '/users.*', function() {
			$this->controller = new Controllers\UserController($this->pdo, $this->twig);
		});
		$this->router->mount('/users', function() {
			$this->router->get('/', function() {
				// List users
				$this->controller->list();
			});
			$this->router->get('/([0-9]+)', function($id) {
				// Display a user
				$this->controller->get($id);
			});
			$this->router->get('/add', function() {
				// View form to add a new user
				$this->controller->get(0);
			});
			$this->router->patch('/([0-9]+)', function($id) {
				// TODO: Update a user
			});
			$this->router->delete('/', function() {
				// TODO: Delete a user
			});
			$this->router->post('/', function() {
				// TODO: Add a user
			});
		});
	}
	
	private function notFound()
	{
	    header('HTTP/1.1 404 Not Found', true);
	    echo '404 Not Found';
	}
}
?>
