<?php
namespace MoS\LAN\Views;

use MoS\LAN\Models\Listable,
    Twig\Environment;

class ListView extends AbstractView
{	
	public function __construct(Environment $twig, Listable $model)
	{
		parent::__construct($twig, $model);
	}
	public function display()
	{
		$list = $this->model->getList();
		$title = $this->model->getListTitle();
		$header = $this->model->getListHeader();
		$params = array(
			'title' => $title,
			'header' => $header,
			'list' => $list
		);
		$this->twig->display('list.html', $params);
	}
}