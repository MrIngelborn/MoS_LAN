<?php
namespace MoS\LAN\Helpers;

use Symfony\Component\Yaml\Yaml;
use PDO;

class PDOFactory
{
	/*
	* Creates a PDO object from coniguration file
	* @return The PDO object or null if file does not exist
	*/
	public static createFromYamlConfig($fileName): ?PDO
	{
		$pdo = null;
		if (is_readable($fileName)) {
			// Read and parse the file
			$config = Yaml::parseFile($yamlFile);
			
			$host = isset($config['host']) ? $config['host'] : 'localhost';
			$port = isset($config['port']) ? ';port='.$config['port'] : '';
			$dbname = isset($config['dbname']) ? ';dbname='.$config['dbname'] : '';
			$charset = isset($config['charset']) ? ';charset='.$config['charset'] : '';
			$user = isset($config['user']) ? $config['user'] : '';
			$pass = isset($config['pass']) ? $config['pass'] : '';
			
			$dsn = "mysql:host=$host$port$dbname$charset";
			
			$pdo = new PDO($dsn, $user, $pass);
		}
		return $pdo;
	}
}