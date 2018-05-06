<?php
namespace MoS\LAN\Models;

class PageModel
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
		$this->fetchData();
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
		return $this->data;
	}
	
	public function hasData()
	{
		return sizeof($this->data) > 0;
	}
}