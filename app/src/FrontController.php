<?php
namespace MoS\LAN;

use Twig\Environment,
    Bramus\Router\Router;

class FrontController
{
	private $twigEnvironment;
	private $router;
	private $pdo;
	
	public function __construct(Environment $twig, Router $router, \PDO $pdo)
	{
		$this->twigEnvironment = $twig;
		$this->router = $router;
		$this->pdo = $pdo;
	}
	public function handleRequest()
	{
		$this->twigEnvironment->display('index.html');
	}
}
?>
