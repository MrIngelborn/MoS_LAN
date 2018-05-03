<?php
namespace MoS\LAN\Controller;

use MoS\LAN\Routing\RequestInterface,
	MoS\LAN\Routing\ResponseInterface;

class PageController
{
	const VIEW_NAMESPCE = 'MoS\LAN\Views\\';
	public function __construct()
	{	
	}
	
	/*
	* Display page with name and parameters
	*/
	private function display($page, $params)
	{
		$class = self::VIEW_NAMESPCE . ucfirst(strtolower($page)) . 'View';
		$instance = new $class;
        call_user_func_array(array($instance, 'view'), $params);
	}
	
	/**
	* Catch all actions not declared
	*/
	public function __call($method_name, $args) {
        $this->display($method_name, $args);
    }

}