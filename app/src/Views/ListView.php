<?php
namespace MoS\LAN\Views;

use MoS\LAN\Models\Listable,
    Twig\Environment;

class ListView
{
	private $twig;
	private $model;
	
	public function __construct(Environment $twig, Listable $model)
	{
		$this->twig = $twig;
		$this->model = $model;
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