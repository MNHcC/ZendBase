<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\Module {

    use Zend\ModuleManager\Feature\BootstrapListenerInterface;
    use Zend\EventManager\EventManagerAwareInterface;
    use Zend\Mvc\ApplicationInterface;
    use MNHcC\Zend3bcHelper\ServiceManager\ServiceLocatorAwareInterface; //use from MNHcC\Zend3bcHelper for fixing removed from zf3

    /**
     * Description of BasicModuleInterface
     *
     * @author carschrotter
     */
    interface BasicModuleInterface extends BootstrapListenerInterface, EventManagerAwareInterface, ServiceLocatorAwareInterface {
        
	/**
	 * 
	 * @return ApplicationInterface
	 */
	public function getApplication();

	/**
	 * 
	 * @param ApplicationInterface $application
	 * @return static
	 */
	public function setApplication(ApplicationInterface $application);
    }

}