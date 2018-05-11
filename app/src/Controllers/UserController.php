<?php
namespace MoS\LAN\Controllers;

use Twig\Environment;
use MoS\LAN\Models\UserModel,
    MoS\LAN\Views\ListView,
    MoS\LAN\Views\UserView;

class UserController
{
	private $twig;
	private $model;
	
	public function __construct(\PDO $pdo, Environment $twig)
	{
		$this->twig = $twig;
		$this->model = new UserModel($pdo);
	}
	
	public function get($id)
	{
		$this->model->fetchById($id);
		new UserView($this->twig, $this->model);
	}
	public function update($id)
	{
		
	}
	public function delete($id)
	{
		
	}
	public function add()
	{
		
	}
	public function list()
	{
		$this->model->fetchList();
		$view = new ListView($this->twig, $this->model);
	}
}