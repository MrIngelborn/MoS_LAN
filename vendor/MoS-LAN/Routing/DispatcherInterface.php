<?php
namespace MoS\LAN\Routing;

interface DispatcherInterface {
	public function dispatch(RouteInterface $route, RequestInterface $request, ResponseInterface $response);
}
?>