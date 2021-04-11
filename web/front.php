<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;

require __DIR__ . "/../vendor/autoload.php";

$container = include __DIR__ . "/../config/container.php";

$request  = Request::createFromGlobals();

$response = $container->get('app')->handle($request);

$response->send();

