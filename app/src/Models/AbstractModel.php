<?php
namespace MoS\LAN\Models;

abstract class AbstractModel
{
	protected $pdo;
	protected $data;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	abstract public function fetchById($id);
	
	protected function fetchData($query, $params)
	{
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($params);
		$this->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function hasData()
	{
		if (!$this->data) {
			$this->fetchData();
		}
		return sizeof($this->data) > 0;
	}
}