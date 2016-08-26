<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\ModuleManager\Feature {

    use Zend\Loader\ClassMapAutoloader;
    use Zend\Loader\StandardAutoloader;
    use MNHcC\Exception\RequiredNotFoundException;
    
    const DS = \DIRECTORY_SEPARATOR;
    
    /**
     * AutoloaderProviderTrait
     * A trait for the modules implement the Autoload Interface.
     */
    trait AutoloaderProviderTrait {

        /**
         * 
         * @return array
         * @throws RequiredNotFoundException
         */
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
                throw new RequiredNotFoundException('No sourcepath found');
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
