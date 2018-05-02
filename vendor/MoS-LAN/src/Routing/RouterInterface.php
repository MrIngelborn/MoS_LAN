<?php
namespace MoS\LAN\Routing;

interface RouterInterface
{
	public function addRoute(RouteInterface $route);
	public function addRoutes(array $routes);
	public function getRoutes();
	public function route(RequestInterface $request);
}
?>