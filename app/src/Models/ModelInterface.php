<?php
namespace MoS\LAN\Models;

interface ModelInterface
{
	public function __construct(\PDO $pdo);
	public function fetchById($id);
	public function getData();
	public function hasData();
}