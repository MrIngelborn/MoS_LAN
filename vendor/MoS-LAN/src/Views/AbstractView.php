<?php
namespace MoS\LAN\Views;

abstract class AbstractView implements ViewInterface
{
	protected $doctype = '<!doctype html>'; // HTLM 5
	protected $charset = 'UTF-8';
	
	protected $title = 'MoS LAN';
	protected $js_sources = array();
	protected $css_sources = array();
	
	public function __construct(array $params = array())
	{
		$this->addJS('/assets/javascript/jquery/jquery-3.3.1.min.js');
		$this->addCSS('/assets/stylesheets/spectre/spectre.min.css');
	}
	
	public function view($params = array()): void
	{
		
		$this->print_row($this->doctype);
		$this->print_row('<html>');
		$this->print_row('<head>');
		$this->head();
		$this->print_row('</head>');
		$this->print_row('<body>');
		$this->body();
		$this->print_row('</body>');
		$this->print_row('</html>');
	}
	
	protected function head()
	{
		// Print charset
		$this->print_row("<meta charset=\"{$this->charset}\">");
		
		// Print javascripts
		foreach($this->js_sources as $src) {
			$this->print_row("<script src=\"$src\"></script>");
		}
		
		// Print stylesheets
		foreach($this->css_sources as $src) {
			$this->print_row("<link rel=\"stylesheet\" href=\"$src\">");
		}
	}
	
	protected abstract function body();
	
	protected function print_row($row, $linebreak = false)
	{
		echo $row;
		if ($linebreak) echo '<br/>';
		echo PHP_EOL;
	}
	
	protected function addJS($src)
	{
		$this->js_sources[] = $src;
	}
	protected function addCSS($src)
	{
		$this->css_sources[] = $src;
	}
}
?>