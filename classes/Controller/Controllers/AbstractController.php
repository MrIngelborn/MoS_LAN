<?php
namespace MoS\LAN\Controller\Controllers;

abstract class AbstractController implements ControllerInterface
{
	protected $title = 'MoS LAN';
	protected $charset = 'UTF-8';
	protected $css_links = array();
	protected $js_links = array();
	
	public function __construct()
	{
		$this->css_links[] = '/css/spectre/spectre.min.css';
		
		$this->js_links[] = '/js/jquery/jquery-3.3.1.min.js';
	}
	
	public function display(array $args = array())
	{
		echo '<!doctype html>', PHP_EOL;
		echo '<html>', PHP_EOL;
		echo '<head>', PHP_EOL;
		$this->the_header();
		echo '</head>', PHP_EOL;
		echo '<body>', PHP_EOL;
		echo $this->the_content(), PHP_EOL;
		echo $this->the_footer(), PHP_EOL;
		echo '</body>', PHP_EOL;
		echo '</html>';
	}
	
	/**
	* Prints the content that should be within the head tag
	*/
	protected function the_header() {
		// Set charset
		echo "<meta charset=\"$this->charset\">", PHP_EOL;
		
		// Print title
		echo "<title>$this->title</title>", PHP_EOL;
		 
		// Print all css links
		foreach($this->css_links as $link) {
			echo "<link rel=\"stylesheet\" href=\"$link\">", PHP_EOL;
		}
		// Print all javascript links
		foreach ($this->js_links as $link) {
			echo "<script type=\"text/javascript\" src=\"$link\"></script>", PHP_EOL;
		}
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