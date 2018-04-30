<?php
namespace MoS\LAN\Controller\Controllers;

class PageController extends AbstractController
{
	public function __construct()
	{
		// Set the deafult state
		parent::__construct();
		
		$this->title = $this->title . ' | Home';
	}
	
	/**
	* @return The mail content of the page
	*/
	protected function the_content()
	{
		return 'INDEX';
	}

}