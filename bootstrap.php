<?php

// Setup my autoloader
require_once __DIR__."/vendor/Psr4AutoloaderClass.php";
$autoloader = new Psr4AutoloaderClass;
$autoloader->register();
$autoloader->addNamespace('MoS\LAN', __DIR__.'/app/src');
$autoloader->addNamespace('MoS\LAN', __DIR__.'/app/test');

// Load conposers autoloader
require_once __DIR__.'/vendor/autoload.php';

// Specify Twig templates location
$loader = new Twig_Loader_Filesystem(__DIR__.'/app/src/Templates');

 // Instantiate Twig
$twig = new Twig_Environment($loader);

?>