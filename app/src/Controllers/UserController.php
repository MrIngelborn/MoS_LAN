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
	public function add()
	{
		//var_dump($_POST);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$admin = isset($_POST['admin']) ? 1 : 0;
		
		$min_len_username = 4;
		$min_len_password = 8;
		
		// Check validity of username and password
		if (!function (): bool {
			if (sizeof($username) < $min_len_username) return false;
			if (sizeof($password) < $min_len_password) return false;
			return true;
		}) {
			// Username and/or password is not valid
			return;
		}
		// Create array for user properties
		$user = array(
			'username' => $username,
			'password' => $password,
			'admin' => $admin
		);
		// Get array of available properties
		$properties = $this->model->getProperties();
		
		foreach ($properties as $index => $property) {
			if (array_key_exists($property, $user)) {
				// The property is a core property, has already been specified
				continue;
			}
			if (!array_key_exists($property, $_POST)) {
				// Property has not been specified in post request
				continue;
			}
			if ($_POST[$property] == null || sizeof(trim($_POST[$property])) == 0) {
				// No information, value does not have to be set
				continue;
			}
			$user[$property] = trim($_POST[$property]);
		}
		
		$this->model->add($user);
	}
	public function delete($id)
	{
		
	}
	public function list()
	{
		$this->model->fetchList();
		$view = new ListView($this->twig, $this->model);
	}
}