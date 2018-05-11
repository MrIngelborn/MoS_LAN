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
		if ($id > 0){
			$this->model->fetchById($id);
		}
		new UserView($this->twig, $this->model);
	}
	public function update($id)
	{
		$changed = array();
		if ($_POST['username'] != $_POST['_username']) {
			$changed['username'] = $_POST['username'];
		}
		if (isset($_POST['admin']) != $_POST['_admin']) {
			$changed['admin'] = isset($_POST['admin']) ? 1 : 0;
		}
		if ($_POST['name'] != $_POST['_name']) {
			$changed['name'] = $_POST['name'];
		}
		$this->model->update($id, $changed);
		
		// Display info of the updated user
		$this->get($id);
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