<?php
namespace MoS\LAN\Controller;

use MoS\LAN\Routing\RequestInterface,
	MoS\LAN\Routing\ResponseInterface;

class PageController
{
	public function __construct()
	{	
	}
	
	/*
	* Display page with name and parameters
	*/
	private function display($page, $params)
	{
		echo $page, '<br/>', PHP_EOL;
		var_dump($params);
	}
	
	/**
	* Catch all actions not declared
	*/
	public function __call($method_name, $args) {
        $this->display($method_name, $args);
    }

}