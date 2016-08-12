<?php

namespace MNHcC\Module {

    use Zend\ModuleManager\Feature\BootstrapListenerInterface;
    use Zend\EventManager\EventManagerAwareInterface;
    use Zend\ServiceManager\ServiceLocatorAwareInterface; //use from zf2 or on zf3 from MNHcC\Zend3bcHelper

    /**
     * Description of BasicModuleInterface
     *
     * @author carschrotter
     */
    interface BasicModuleInterface extends BootstrapListenerInterface, EventManagerAwareInterface, ServiceLocatorAwareInterface {
        
    }

}