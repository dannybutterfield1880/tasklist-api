<?php
require __DIR__.'/bootstrap.php';

$pathExplode = explode('/', $_GET['url']);

$controllerTitle = ucfirst($pathExplode[0]);
$controllerName = $controllerTitle.'Controller';
$method = $pathExplode[1] . $controllerTitle . 'Action';
$param = $pathExplode[2];

require_once(__DIR__.'/src/Core/Controller/'.$controllerName.'.php');

$controllerClass = 'Core\\Controller\\'.$controllerName;

$controller = new $controllerClass();

$controller->$method($param);

?>  