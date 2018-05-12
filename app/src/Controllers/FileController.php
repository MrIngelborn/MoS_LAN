<?php
namespace MoS\LAN\Controllers;

use Twig\Environment;

class FileController
{	
	private const ASSETS_PATH = '/app/assets/';
	private const CSS_PATH = 'css/';
	private const JS_PATH = 'js/';
	
	private $jsPath, $cssPath;
	
	public function __construct()
	{
		$this->jsPath = $_SERVER['DOCUMENT_ROOT'].self::ASSETS_PATH.self::JS_PATH;
		$this->cssPath = $_SERVER['DOCUMENT_ROOT'].self::ASSETS_PATH.self::CSS_PATH;
	}
	
	public function getFile($path, $filename)
	{
		$path_array = explode('/', $path);
		
		if (strtolower($path_array[0]) === 'css') {
			$subpath = $path_array;
			unset($subpath[0]);
			$subpath = implode('/', $subpath);
			
			$filepath = $this->cssPath.$subpath.'/'.$filename;
			
			if ($this->printFile($filepath)) {
				return;
			}
		}
		
		if (strtolower($path_array[0]) === 'js') {
			$subpath = $path_array;
			unset($subpath[0]);
			$subpath = implode('/', $subpath);
			
			$filepath = $this->jsPath.$subpath.'/'.$filename;
			
			if ($this->printFile($filepath)) {
				return;
			}
		}
		
		echo 'File "', $path, '/', $filename, '" could not be found';
	}
	
	private function printFile($filepath): bool
	{
		if (file_exists($filepath)) {
			echo file_get_contents($filepath);
			return true;
		}
		return false;
	}
}

?>