<?php
namespace MoS\LAN\Views;

use MoS\LAN\Models\AbstractModel,
    Twig\Environment;
    
abstract class AbstractView implements ViewInterface
{
	protected $model;
	protected $twig;
	
	public function __construct(Environment $twig, AbstractModel $model)
	{
		$this->model = $model;
		$this->twig = $twig;
		$this->display();
	}
	
	abstract public function display();
}