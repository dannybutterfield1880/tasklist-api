<?php

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/vendor/autoload.php';
include __DIR__.'/bootstrap.php';

use Brick\Http\Request;
use Brick\Http\Response;

//parse url string and return controller, method and param
[$controllerClass, $method, $params] = parseUrlString($_GET['url']);

/** @var Controller $controller */
$controller = new $controllerClass($entityManager, new Request, new Response, $serializer);

$controller->$method(...$params);

?>  