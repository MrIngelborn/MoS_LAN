<?php
namespace MoS\LAN\Controllers;

use Twig\Environment;
use MoS\LAN\Models\UserModel,
    MoS\LAN\Views\ListView;

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
		$view = new UserView($twig);
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
		$view = new ListView($this->twig, $this->model);
	}
}