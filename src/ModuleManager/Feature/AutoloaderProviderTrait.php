<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\ModuleManager\Feature {

    use Zend\Loader\ClassMapAutoloader;
    use Zend\Loader\StandardAutoloader;
    
    const DS = \DIRECTORY_SEPARATOR;
    
    /**
     * AutoloaderProviderTrait
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    trait AutoloaderProviderTrait {

	public function getAutoloaderConfig() {
            $sourcefolder = false;
	    $self_rfl = new \ReflectionObject($this);
	    $__DIR__ = \dirname($self_rfl->getFileName());
	    $__NAMESPACE__ = $self_rfl->getNamespaceName();
            $pathFromNamespace = \str_replace('\\', DS, $__NAMESPACE__);
            $regex = \sprintf('~%s$~', \preg_quote($pathFromNamespace, '~'));
            $sourcefolderfromNamespace = \preg_replace($regex, '', $__DIR__);

            foreach ([$__DIR__ . DS . 'src', $sourcefolderfromNamespace,] as $filename) {
                if (\file_exists($filename)) {
                    $sourcefolder = $filename; //find posible sourcepath
                }
            }
            
            if(!$sourcefolder) {
                throw new \LogicException('No sourcepath found');
            }

            $config = [
		StandardAutoloader::class => [
		    'namespaces' => [
			$__NAMESPACE__ => $sourcefolder .DS. $pathFromNamespace,
		    ],
		],
	   ];
           if (\file_exists($sourcefolder . DS . 'autoload_classmap.php')) {
                $config[ClassMapAutoloader::class] = [$sourcefolder . DS . 'autoload_classmap.php'];
            }

            return $config;
	}

    }

}
