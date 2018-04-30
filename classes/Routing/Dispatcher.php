<?php
namespace MoS\LAN\Routing;

class Dispatcher implements DispatcherInterface {

	public function dispatch(RouteInterface $route, RequestInterface $request, ResponseInterface $response)
	{
		$controller = $route->createController();
		$controller->execute($request, $response);
	}
}
?>