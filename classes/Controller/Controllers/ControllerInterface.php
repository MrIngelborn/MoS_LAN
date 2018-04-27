<?php
namespace MoS\LAN\Controller\Controllers; 

interface ControllerInterface
{
	/**
	* Display the page with the given aguments
	* @param args array of arguments to the controller
	*/
	public function display(array $args = array());
}