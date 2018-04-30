<?php
namespace MoS\LAN\Routing;

interface RequestInterface {
	public function getUri();
	public function setParam($key, $value);
	public function getParam($key);
	public function getParams();
?>