<?php
namespace MoS\LAN\Controllers;

use MoS\LAN\Models\PageModel,
    MoS\LAN\Views\PageView,
    MoS\LAN\Views\ListView,
    Twig\Environment;

class PageController implements ControllerInterface
{
	private $model;
	private $twig;
	
    public function __construct(\PDO $pdo, Environment $twig)
    {
	    $this->model = new PageModel($pdo);
	    $this->twig = $twig;
    }
    
    /*
	* Display a single page
	* 
	* @param $name the name of the page
	*/
    public function get($name)
    {
	    $this->model->fetchByName($name);
	    new PageView($this->twig, $this->model);;
    }
    public function list()
    {
	    $this->model->fetchList();
	    new ListView($this->twig, $this->model);
    }
}