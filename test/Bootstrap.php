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

//echo 'class_exists(MNHcC\Zend3bcHelper\Module::class, false): '. (class_exists(MNHcC\Module::class, false) ? 'JA' : 'NEIN') . PHP_EOL;
//echo 'class_exists(MNHcC\Zend3bcHelper\Module::class, true): '. (class_exists(MNHcC\Module::class, true) ? 'JA' : 'NEIN') . PHP_EOL;
$configuration = include 'config/application.config.php';
$moduleLoader = new ModuleLoader($configuration);
/* @var $serviceManager ServiceManager */
$serviceManager = $moduleLoader->getServiceManager();