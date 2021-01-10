<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\Common\Proxy\Autoloader;


function makeEntityManager() {
    $isDevMode = true;
    $proxyDir = null;
    $cache = null;

    $logger = new DebugStack();
    $useSimpleAnnotationReader = false;
    dump($_ENV);
    
    if ('development' == "development") {
        $cache = new \Doctrine\Common\Cache\ArrayCache;
    } else {
        $cache = new \Doctrine\Common\Cache\ApcuCache;
    }

    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
    // or if you prefer yaml or XML
    //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
    //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);
    $config->setMetadataCacheImpl($cache);
    //$driverImpl = $config->newDefaultAnnotationDriver(__DIR__.'/src/Core/Entities');
    //$config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl($cache);
    // $config->setProxyDir($proxyDir);
    // $config->setProxyNamespace($proxyNamespace);


    $config->setSQLLogger($logger);
    // database configuration parameters
    $conn = array(
        'driver' => 'pdo_mysql',
        'host' => "127.0.0.1",
        "port" => '3306',
        "user" => "root",
        "password" => "Butterf1eld",
        "dbname" => "tasklists"
    );

    // obtaining the entity manager
    return EntityManager::create($conn, $config);
}