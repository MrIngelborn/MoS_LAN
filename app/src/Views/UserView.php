<?php
namespace MoS\LAN\Views;

use MoS\LAN\Models\UserModel,
    Twig\Environment;

class UserView extends AbstractView
{
	public function __construct(Environment $twig, UserModel $model)
	{
		parent::__construct($twig, $model);
	}
	public function display()
	{
		$data = $this->model->getData();
		$params = array(
			'title' => 'User Form'
		);
		if (sizeof($data)) {
			$params['user'] = $data[0];
			$params['header'] = 'Update user #'.$data[0]['id'];
			$params['submit'] = 'Update';
		}
		else {
			$params['header'] = 'Create new user';
			$params['submit'] = 'Create';
		}
		$this->twig->display('user.html', $params);
	}
}