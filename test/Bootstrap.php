<?php

use Zend\Test\Util\ModuleLoader;
use Zend\ServiceManager\ServiceManager;

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup autoloading
require 'init_autoloader.php';

$configuration = include 'config/application.config.php';
if (class_exists(Zend\Router\Module::class)) {
    $configuration['modules'][] = Zend\Router::class;
}
$moduleLoader = new ModuleLoader($configuration);
/* @var $serviceManager ServiceManager */
$serviceManager = $moduleLoader->getServiceManager();