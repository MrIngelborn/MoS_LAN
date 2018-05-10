<?php
namespace MoS\LAN\Models;

class UserModel extends AbstractModel implements Listable
{
	protected const TABLE = 'login';
	
	public function fetchById($id)
	{
		$query = 'SELECT * FROM '.self::TABLE.' WHERE id = :id LIMIT 1';
		$params = array(':id' => $id);
		$this->fetchData($query, $params);
	}
	public function fetchList()
	{
		$query = 'SELECT id, username FROM '.self::TABLE;
		$this->fetchData($query, null);
	}
	public function getList()
	{
		$list = array();
		foreach ($this->data as $user) {
			$list[] = array(
				'href' => 'users/'.$user['id'],
				'value' => $user['username']
			);
		}
		return $list;
	}
	public function getListTitle()
	{
		return 'Users';
	}
	public function getListHeader()
	{
		return 'List och Users'
	}
	
	
}