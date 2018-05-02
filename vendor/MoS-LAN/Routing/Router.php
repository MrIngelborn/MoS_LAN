<?php
namespace MoS\LAN\Routing;

class Router implements RouterInterface {
	private $routes;
	
	public function __construct($routes) 
	{
		$this->addRoutes($routes);
	}
	
	public function addRoute(RouteInterface $route) 
	{
		$this->routes[] = $route;
		return $this;
	}
	
	public function addRoutes(array $routes) 
	{
		foreach ($routes as $route) {
			$this->addRoute($route);
		}
		return $this;
	}
	
	public function getRoutes() 
	{
		return $this->routes;
	}
	
	/**
	* Find the route for the given request
	* @return The route or false if no route was found
	*/
	public function route(RequestInterface $request): ?RouteInterface
	{
		foreach ($this->routes as $route) {
			if ($route->match($request)) {
				return $route;
			}
		}
		
		//throw new \OutOfRangeException("No route matched the given URI.");
		return null;
	}
}
?>