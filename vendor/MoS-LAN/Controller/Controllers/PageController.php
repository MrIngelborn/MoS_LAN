<?php
namespace MoS\LAN\Controller\Controllers;

use MoS\LAN\Routing\RequestInterface,
	MoS\LAN\Routing\ResponseInterface;

class PageController implements ControllerInterface
{
	public function __construct()
	{
		
	}
	
	/**
	* Execute the given request
	*/
	public function execute(RequestInterface $request, ResponseInterface $response){
		echo 'INDEX';
	}

}