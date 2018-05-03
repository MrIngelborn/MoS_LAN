<?php
/**
* Creates and stores routing configuration
*
* @author MrIngelborn
*/
namespace MoS\Router;

final class Config
{
	/**
	* Keep construction private
	*/
	private function __construct()
	{
		
	}
	
	/**
	* Load configuration from YAML file
	*/
	public static function fromYAMLFile($filepath): ?Config
	{
		if (!file_exists($filepath))
			return false;
		
		$config = yaml_parse_file($filepath);
		return new Config;
	}
}

?>