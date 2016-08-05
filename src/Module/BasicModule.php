<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\Module {

    use \Zend\ModuleManager\Feature\BootstrapListenerInterface,
	\Zend\EventManager\EventInterface,
	\Zend\EventManager\EventManagerAwareInterface,
	\Zend\EventManager\EventManagerAwareTrait,
	\Zend\EventManager\EventManagerInterface,
	\Zend\Mvc\ApplicationInterface,
	\Zend\Mvc\MvcEvent,
	\Zend\ServiceManager\ServiceLocatorAwareInterface,
	\Zend\ServiceManager\ServiceLocatorAwareTrait,
	\MNHcC\Event\Listener\ModuleMatchListener,
	\MNHcC\Event\Mvc\ModuleMatchEvent;

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
//	    $eventManager->attach([MvcEvent::EVENT_DISPATCH],
//		    [$this, 'onDispatch'], 100);
	    
	    $moduleMatchListener = new ModuleMatchListener($this);
	    $moduleMatchListener->attach($eventManager, 100);
	    	    
	    //$this->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
	}

//	public function onDispatch(MvcEvent $e) { //set template fals controller nicht gefunden
//	    $this->getEventManager()->trigger(
//		    $e->setName(ModuleMatchEvent::EVENT_BEFORE_MODULE_MATCH)
//		    ->setParam('module', $this));
//	}

    }

}

