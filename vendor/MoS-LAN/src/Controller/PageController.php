<?php
namespace MoS\LAN\Controller;

class PageController extends AbstractController
{
	public function __construct()
	{	
	}
	
	/*
	* Display page with name and parameters
	*/
	protected function display($page, array $params = array())
	{
		$class = self::VIEW_NAMESPACE . ucfirst(strtolower($page)) . 'View';
		$view = new $class($params);
		$view->view();
	}
	
	/**
	* Catch all actions not declared
	*/
	public function __call($method_name, $args)
	{
        $this->display($method_name, $args);
    }
    
    public function test($a)
    {
	    print_r($a);
    }

}