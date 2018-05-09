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
		$data = $this->model->getData();
		$params = array();
		if (sizeof($data) > 0) {
			$params['title'] = $data[0]['title'];
			$params['content'] = $data[0]['content'];
		}
		else {
			$params['title'] = 'Page not found';
			$params['content'] = <<<EOL
<h1>Page not Found</h1>
The page you where looking for does not exist.<br/>
Click <a href="../">here</a> to display a list of pages.
EOL;
		}
		$this->twig->display('page.html', $params);
	}
}