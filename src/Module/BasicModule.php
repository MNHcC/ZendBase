<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\Module {

    use Zend\ModuleManager\Feature\BootstrapListenerInterface;
    use Zend\EventManager\EventInterface;
    use Zend\EventManager\EventManagerAwareInterface;
    use Zend\EventManager\EventManagerAwareTrait;
    use Zend\EventManager\EventManagerInterface;
    use Zend\Mvc\ApplicationInterface;
    use Zend\ServiceManager\ServiceLocatorAwareInterface;
    use Zend\ServiceManager\ServiceLocatorAwareTrait;
    use MNHcC\Event\Listener\ModuleMatchListener;

    /**
     * BasicModule
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    abstract class BasicModule implements BootstrapListenerInterface, EventManagerAwareInterface, ServiceLocatorAwareInterface {

	use EventManagerAwareTrait {
	    setEventManager as setEventManagerTrait;
	}
        
	use  ServiceLocatorAwareTrait;
	
	/**
	 * Set the event manager instance used by this context.
	 *
	 * For convenience, this method will also set the class name / LSB name as
	 * identifiers, in addition to any string or array of strings set to the
	 * $this->eventIdentifier property.
	 *
	 * @param  EventManagerInterface $events
	 * @return mixed
	 */
	public function setEventManager(EventManagerInterface $events)
	{
	    return $this->setEventManagerTrait($events)
		    ->getEventManager()
		    ->setIdentifiers( \array_merge(
			    $this->getEventManager()->getIdentifiers(),
			    ['Module']
			)
		    );
	}

	/**
	 *
	 * @var \Zend\Mvc\ApplicationInterface 
	 */
	protected $application;

	/**
	 * 
	 * @return \Zend\Mvc\ApplicationInterface
	 */
	public function getApplication() {
	    return $this->application;
	}

	/**
	 * 
	 * @param \Zend\Mvc\ApplicationInterface $application
	 * @return static
	 */
	public function setApplication(ApplicationInterface $application) {
	    $this->application = $application;
	    return $this;
	}

	/**
	 * Listen to the bootstrap event
	 *
	 * @param EventInterface $e
	 * @return array
	 */
	public function onBootstrap(EventInterface $e) {
	    if (!$this->getServiceLocator()) {
		$this->setApplication($e->getApplication())
			->setServiceLocator($this->getApplication()->getServiceManager());
	    }
	    /* @var $eventManager \Zend\EventManager\EventManagerInterface */
	    $eventManager = $this->getApplication()->getEventManager();
	    $moduleMatchListener = new ModuleMatchListener($this);
	    $moduleMatchListener->attach($eventManager, 100);

	}

    }

}

