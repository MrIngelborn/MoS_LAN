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
		
		$this->router->before('GET', '/', function() {
			header('Location: /pages/index');
			die();
		});
		
		$this->router->mount('/pages', function() {
			$initPages = function() {
				$this->model = new Models\PageModel($this->pdo);
				$this->controller = new Controllers\PageController($this->model);
			};
			
			$this->router->get('/', function() use ($initPages) {
				// List Pages
				$initPages();
				$this->view = new Views\ListView($this->twig, $this->model);
			});
			$this->router->get('/(\w+)', function($name) use ($initPages) {
				$initPages();
				$this->controller->get($name);
				$this->view = new Views\PageView($this->twig, $this->model);
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
