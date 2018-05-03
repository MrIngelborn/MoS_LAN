<?php
namespace MoS\LAN\Controller;

use MoS\LAN\Routing\RequestInterface,
	MoS\LAN\Routing\ResponseInterface;

interface ControllerInterface
{
	/**
	* Execute the given request
	*/
	public function execute(RequestInterface $request, ResponseInterface $response);
}