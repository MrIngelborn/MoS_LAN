<?php
namespace MoS\LAN\Routing;

interface ResponseInterface {
	public function getVersion();
	public function addHeader($header);
	public function addHeaders(array $headers);
	public function getHeaders();
	public function send();
}
?>