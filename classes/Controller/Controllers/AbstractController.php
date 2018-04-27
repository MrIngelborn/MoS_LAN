<?php
namespace MoS\LAN\Controller\Controllers;

abstract class AbstractController implements ControllerInterface
{
	protected $title = "MoS LAN";
	protected $delimiter = "\t";
	
	public function display(array $args = array())
	{
		echo '<doctype html>', PHP_EOL;
		echo '<html>', PHP_EOL;
		echo '<header>', PHP_EOL;
		echo the_header();
		echo '</header>', PHP_EOL;
		echo '<body>', PHP_EOL;
		echo the_content(), PHP_EOL;
		echo the_footer(), PHP_EOL;
		echo '</body>', PHP_EOL;
		echo '</html>';
	}
	
	/**
	* @return The content that should be within the header tag
	*/
	protected function the_header() {
		
	}
	
	/**
	* @return The data that should be displayed on the bottom of the page
	*/
	protected function the_footer() {
		
	}
	
	/**
	* @return The mail content of the page
	*/
	protected abstract function the_content();
}

?>