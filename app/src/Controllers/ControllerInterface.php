<?php
namespace MoS\LAN\Controllers;

use Twig\Environment;

interface ControllerInterface
{
	public function __construct(\PDO $pdo, Environment $twig);
}
