<?php
namespace MoS\LAN\Models;

abstract class AbstractModel
{
	abstract public function fetchById($id);
	
	protected function fetchData($query, $params)
	{
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
		if (!$this->data) {
			$this->fetchData();
		}
		return sizeof($this->data) > 0;
	}
}