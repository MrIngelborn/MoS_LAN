<?php
namespace MoS\LAN\Views;

interface ViewInterface
{
	/*
	* Display the view to the user
	* @param $params parameters fom the request
	*/
	public function view($params = array()): void;
}
?>