<?php
namespace MoS\LAN\Controller\Controllers;

use MoS\LAN\Routing\RequestInterface,
	MoS\LAN\Routing\ResponseInterface;

class ErrorController implements ControllerInterface
{
	/**
	* Execute the given request
	*/
	public function execute(RequestInterface $request, ResponseInterface $response)
	{
		switch ($request->getParam('code')) {
			case '404':
				$uri = urldecode($request->getParam('uri'));
				echo '404 Page not found: '.$uri;
				break;
			default:
				break;
		}
	}

}