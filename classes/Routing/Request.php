<?php
namespace MoS\LAN\Routing;

class Request implements RequestInterface
{
	private $method;
	private $path;
	private $params;
	private $uri;
	
	public function __construct($method, $uri)
	{ 
		$path = parse_url($uri, PHP_URL_PATH);
		$query = parse_url($uri, PHP_URL_QUERY);
		
		if (sizeof($query) > 0) {
			$query_params = explode('&', $query);
			foreach($query_params as $query_param) {
				$query_param_array = explode('=', $query_param);
				assert(sizeof($query_param_array) == 2);
				
				$key = $query_param_array[0];
				$value = $query_param_array[1];
				$this->params[$key] = $value;
			}
		}
		
		$this->method = $method;
		$this->path = $path;
		$this->uri = $uri;
	}
	
	public function getPath()
	{
		return $this->path;
	}
	
	public function setParam($key, $value)
	{
		$this->params[$key] = $value;
		return $this;
	}
	
	public function getParam($key)
	{
		if (!isset($this->params[$key])) {
			throw new \InvalidArgumentException("The request parameter with key '$key' is invalid."); 
		}
		return $this->params[$key];
	}
	
	public function getParams()
	{
		return $this->params;
	}
	
	public function getMethod()
	{
		return $this->method;
	}
	
	public function getUri()
	{
		return $this->uri;
	}
}
?>