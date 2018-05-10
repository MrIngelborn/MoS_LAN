<?php
namespace MoS\LAN\Models;

class PageModel extends AbstractModel implements Listable
{
	private const TABLE = 'pages';
	
	public function fetchById($id)
	{
		$query = 'SELECT * FROM '.self::TABLE.' WHERE id = :id LIMIT 1';
		$params = array(':id' => $id);
		$this->fetchData($query, $params);
	}
	
	public function fetchByName($name)
	{
		$query = 'SELECT * FROM '.self::TABLE.' WHERE name = :name LIMIT 1';
		$params = array(':name' => $name);
		$this->fetchData($query, $params);
	}
	
	public function fetchList()
	{
		$query = 'SELECT name FROM '.self::TABLE;
		$this->fetchData($query, null);
	}
	
	public function getList()
	{
		$list = array();
		$pages = $this->getData();
		foreach ($pages as $page) {
			$item = array(
				'href' => 'pages/'.$page['name'],
				'value' => $page['name']
			);
			$list[] = $item;
		}
		return $list;
	}
	public function getListTitle()
	{
		return 'Pages';
	}
	public function getListHeader()
	{
		return 'List of Pages';
	}
}