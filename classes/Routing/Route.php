<?php
namespace MoS\LAN\Routing;

class Route implements RouteInterface
{
	private const CONTROLLER_CLASS_NAMESPACE = "\\MoS\\LAN\\Controller\\Controllers\\";
	
	private $path;
	private $controllerClass;
	
	public function __construct($path, $controllerClass) 
	{
		$this->path = $path;
		$this->controllerClass = $controllerClass;
	}
	
	public function match(RequestInterface $request) 
	{
		$request_path_start = substr($request->getPath(), 0, sizeof($this->path));
		return $this->path === $request_path_start;
	}
	
	public function createController() 
	{
		$class = self::CONTROLLER_CLASS_NAMESPACE . $this->controllerClass;
		return new $class;
	}
}
?>