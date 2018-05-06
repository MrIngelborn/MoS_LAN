<?php
namespace MoS\LAN\Views;

use Twig\Environment;
use MoS\LAN\Models\PageModel;

class PageView
{
	private $twig;
	private $model;
	
	public function __construct(Environment $twig, PageModel $model)
	{
		$this->twig = $twig;
		$this->model = $model;
	}
	public function display()
	{
		$data = $this->model->getData()[0];
		$params = array(
			'title' => $data['title'],
			'content' => $data['content']
		);
		$this->twig->display('page.html', $params);
	}
}