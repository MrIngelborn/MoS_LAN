<?php
namespace MoS\LAN\Views;

interface ViewInterface
{
	public function __construct(array $params = array());
	/*
	* Display the view to the user
	*/
	public function view(): void;
}
?>