<?php
namespace MoS\LAN\Controller;

class ErrorController extends PageController
{
	public function error($params)
	{
		$code = $params['code'];
		$code = intval($code);
		switch ($code) {
			case 404:
				header("HTTP/1.1 404 Not Found", true, 404);
			break;
			default:
				echo 'Error: '.$code;
				return;
		}
		$this->display('Error', array('code' => 404));
	}
}