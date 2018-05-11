<?php
namespace MoS\LAN\Views;

use MoS\LAN\Models\UserModel,
    Twig\Environment;

class UserView extends AbstractView
{
	public function __construct(Environment $twig, UserModel $model)
	{
		parent::__construct($twig, $model);
	}
	public function display()
	{
		var_dump($this->model->getData());
	}
}