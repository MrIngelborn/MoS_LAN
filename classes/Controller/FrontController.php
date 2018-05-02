<?php
namespace MoS\LAN\Controller;

use MoS\LAN\Routing\RequestInterface,
	MoS\LAN\Routing\Request,
    MoS\LAN\Routing\ResponseInterface,
    MoS\LAN\Routing\RouterInterface,
    MoS\LAN\Routing\DispatcherInterface;

class FrontController implements FrontControllerInterface
{
	private $router;
	private $dispatcher;
	
	public function __construct(RouterInterface $router, DispatcherInterface $dispatcher) {
		$this->router = $router;
		$this->dispatcher = $dispatcher;
	}
	
	public function run(RequestInterface $request, ResponseInterface $response) {
		$route = $this->router->route($request);
		
		if (!$route) {
			// No route found, add header to 404
			$response->addHeader('404 Page Not Found')->send();
			
			$uri = urlencode($request->getPath());
			$request = new Request('GET', "error?code=404&uri=$uri");
			
			if (!$route = $this->router->route($request)) {
				// No route to Error 404
				echo '404 Page Not Found';
				die();
			}
		}
		
		$this->dispatcher->dispatch($route, $request, $response);
	}
}