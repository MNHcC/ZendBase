<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/**
 * This autoloading setup is really more complicated than it needs to be for most
 * applications. The added complexity is simply to reduce the time it takes for
 * new developers to be productive with a fresh skeleton. It allows autoloading
 * to be correctly configured, regardless of the installation method and keeps
 * the use of composer completely optional. This setup should work fine for
 * most users, however, feel free to configure autoloading however you'd like.
 */


/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Composer autoloading
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

//
//if (class_exists(\Zend\Loader\AutoloaderFactory::class)) {
//    return;
//}

$zf2Path = false;

if (getenv('ZF2_PATH')) {            // Support for ZF2_PATH environment variable
    $zf2Path = getenv('ZF2_PATH');
} elseif (get_cfg_var('zf2_path')) { // Support for zf2_path directive value
    $zf2Path = get_cfg_var('zf2_path');
} elseif(defined(\ZF2_PATH::class)) {// Support for ZF2_PATH constant value
    $zf2Path = \ZF2_PATH;
}

if ($zf2Path) {
    if (isset($loader)) {
        $loader->add('Zend', $zf2Path);
        $loader->add('ZendXml', $zf2Path);
    } elseif(file_exists($zf2Path)) {
        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        \Zend\Loader\AutoloaderFactory::factory(array(
            \Zend\Loader\StandardAutoloader::class => array(
                'autoregister_zf' => true
            )
        ));
    }
}
unset($zf2Path);

if (!class_exists(\Zend\Loader\AutoloaderFactory::class)) {
    throw new \RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}
