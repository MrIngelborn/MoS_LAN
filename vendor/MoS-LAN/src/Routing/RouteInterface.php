<?php
namespace MoS\LAN\Routing;

interface RouteInterface {
	public function match(RequestInterface $request);
	public function createController();
}
?>