<?php
namespace MoS\LAN\Views;

class ErrorView extends AbstractView
{
	private $code;
	
	public function __construct(array $params = array())
	{
		$this->code = isset($params['code']) ? $params['code'] : null;
	}
	
	protected function body()
	{
		$this->print_row('Error: ' . $this->code, true);
	}
}
?>