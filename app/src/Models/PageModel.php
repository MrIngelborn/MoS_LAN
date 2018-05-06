<?php
namespace MoS\LAN\Models;

class PageModel implements Listable
{
	private const TABLE = 'pages';
	private $pdo;
	private $name;
	private $data;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function setCriteria($critera)
	{
		$this->name = $critera;
	}
	
	private function fetchData()
	{
		$query = 'SELECT * FROM '.self::TABLE;
		$params = array();
		if (isset($this->name)) {
			$params[':name'] = $this->name;
			$query .= ' WHERE name = :name';
		}
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($params);
		$this->data = $stmt->fetchAll();
	}
	
	public function getData()
	{
		if (!$this->data) {
			$this->fetchData();
		}
		return $this->data;
	}
	
	public function getList()
	{
		$list = array();
		$pages = $this->getData();
		foreach ($pages as $page) {
			$item = array(
				'href' => $page['name'].'.html',
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
	
	public function hasData()
	{
		if (!$this->data) {
			$this->fetchData();
		}
		return sizeof($this->data) > 0;
	}
}