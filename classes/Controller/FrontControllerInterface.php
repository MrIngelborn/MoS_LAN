<?php
namespace MoS\LAN\Controller;

use MoS\LAN\Routing;

interface FrontControllerInterface
{
    public function run(Routing\RequestInterface $request, Routing\ResponseInterface $response);
}