<?php
namespace MoS\LAN;

use Twig\Environment;

class FrontController
{
	private $twigEnvironment;
	
	public function __construct(Environment $twig)
	{
		$this->twigEnvironment = $twig;
	}
	public function handleRequest()
	{
		$this->twigEnvironment->display('index.html');
	}
}
?>
