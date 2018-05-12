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
		$this->data = $this->query($query, $params);
	}
	
	protected function query($query, $params)
	{
		$stmt = $this->pdo->prepare($query);
		if ($stmt->execute($params)) {
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $stmt->errorinfo();
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