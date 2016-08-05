<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\ModuleManager\Feature {

    use \Zend\Loader\ClassMapAutoloader,
	    \Zend\Loader\StandardAutoloader;
    
    const DS =  \DIRECTORY_SEPARATOR;
    /**
     * AutoloaderProviderTrait
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    trait AutoloaderProviderTrait {

	public function getAutoloaderConfig() {
	    $self_rfl = new \ReflectionObject($this);
	    $__DIR__ = dirname($self_rfl->getFileName());
	    $__NAMESPACE__ = $self_rfl->getNamespaceName();
	    $config = [
		StandardAutoloader::class => [
		    'namespaces' => [
			$__NAMESPACE__ => $__DIR__ .DS. 'src' .DS. $__NAMESPACE__
		    ],
		],
	    ];

	    //moore performance
	    if(file_exists($__DIR__ . DS .'autoload_classmap.php')){
		$config[ClassMapAutoloader::class] = [$__DIR__ . DS .'autoload_classmap.php'] ;
	    }
	    return $config;
	}

    }

}
