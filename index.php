<?php

use Composer\Autoload\ClassLoader;
use Core\Utils\Bootstrap;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/vendor/autoload.php';
require "./helpers.php";

//load Doctrine annotations
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$bootstrap = new Bootstrap();
$bootstrap->execute();


