<?php
namespace MoS\LAN\Controller;

use MoS\LAN\Routing\RequestInterface,
	MoS\LAN\Routing\ResponseInterface;

class ErrorController
{
	public function error($params)
	{
		$code = $params['code'];
		call_user_func(array($this, '_'.$code));
	}
	
	private function _404()
	{
		echo 'Error 404: Not Found';
	}
}