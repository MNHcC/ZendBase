<?php
namespace MNHcC\Module;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use ServiceLocatorAwareInterface

/**
 * Description of BasicModuleInterface
 *
 * @author carschrotter
 */
interface BasicModuleInterface extends BootstrapListenerInterface, EventManagerAwareInterface, ServiceLocatorAwareInterface{

    
}
