<?php

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Logging\DebugStack;

/**
 * create, configure and return an instance of the Doctrine EntityManager
 *
 * @return EntityManager
 * @throws ORMException
 */
function makeEntityManager(): EntityManager
{
    $isDevMode = true;
    $proxyDir = null;
    $cache = null;

    $logger = new DebugStack();
    $useSimpleAnnotationReader = false;

    if ('development' == "development") {
        $cache = new \Doctrine\Common\Cache\ArrayCache;
    } else {
        $cache = new \Doctrine\Common\Cache\ApcuCache;
    }

    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
    //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
    //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);
    $config->setMetadataCacheImpl($cache);
    //$driverImpl = $config->newDefaultAnnotationDriver(__DIR__.'/src/Core/Entities');
    //$config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl($cache);
    // $config->setProxyDir($proxyDir);
    // $config->setProxyNamespace($proxyNamespace);

    $config->setSQLLogger($logger);

    // database configuration
    $conn = array(
        'driver' => 'pdo_mysql',
        'host' => "127.0.0.1",
        "port" => '3306',
        "user" => "root",
        "password" => "",
        "dbname" => "tasklists"
    );

    // return the EntityManager
    return EntityManager::create($conn, $config);
}

/**
 * Take a url path and return controller class, method to call and params to pass
 *
 * @param string $path //url path (i.e /user/load/1 | /{controller}/{method}/{param1}/{param2})
 * @return array ["controller class", "method to call", "params to pass"]
 */
function parseUrlString(string $path): array
{

    $pathExplode = explode('/', $path);
    $controllerTitle = toCamelCase($pathExplode[0]);

    $controllerName = $controllerTitle.'Controller';

    if (!isset($pathExplode[1])) {
        echo 'not method to execute';
        die();
    }

    $method = $pathExplode[1] . $controllerTitle . 'Action';

    unset($pathExplode[0]);
    unset($pathExplode[1]);

    $params = $pathExplode;
    $controllerPath = __DIR__.'/src/Core/Controller/'.$controllerName.'.php';

    if (!file_exists($controllerPath)) {
        echo 'controller not found';
        die();
    }

    //require in controller file
    require_once($controllerPath);

    return [
        'Core\\Controller\\'.$controllerName,
        $method,
        $params
    ];
}

/**
 * Convert string to in camel-case, useful for class name patterns.
 *
 * @param $string
 * @return string
 */
function toCamelCase($string): string
{
    $string = str_replace('-', ' ', $string);
    $string = str_replace('_', ' ', $string);
    $string = ucwords(strtolower($string));
    $string = str_replace(' ', '', $string);
    return $string;
}
