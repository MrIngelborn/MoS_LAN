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
		$text_properties = array('username', 'name');
		$bool_properties = array('admin');
		
		foreach ($text_properties as $property) {
			if (isset($_POST[$property]) && isset($_POST["_$property"]) && $_POST[$property] != $_POST["_$property"]) {
				$changed[$property] = $_POST[$property]; 
			}
		}
		foreach ($bool_properties as $property) {
			if (isset($_POST["_$property"]) && isset($_POST[$property]) != $_POST["_$property"]) {
				$changed[$property] = isset($_POST[$property]) ? 1 : 0; 
			}
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