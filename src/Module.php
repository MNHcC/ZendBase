<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC {

    use Zend\ModuleManager\Feature\BootstrapListenerInterface;
    use Zend\EventManager\EventInterface;
    use Zend\EventManager\EventManagerAwareInterface;
    use Zend\EventManager\EventManagerAwareTrait;
    use Zend\EventManager\EventManagerInterface;
    use Zend\Mvc\ApplicationInterface;
    use Zend\ServiceManager\ServiceLocatorAwareInterface;
    use Zend\ServiceManager\ServiceLocatorAwareTrait;
    use MNHcC\Event\Listener\ModuleMatchListener;
    use MNHcC\Module\BasicModule;

    /**
     * Module
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    class Module extends BasicModule {

        use EventManagerAwareTrait {
            setEventManager as setEventManagerTrait;
        }

        use ServiceLocatorAwareTrait;

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
        public function setEventManager(EventManagerInterface $events) {
             $this->setEventManagerTrait($events);
             return $this->getEventManager()
                        ->setIdentifiers(
                            \array_merge(
                                $this->getEventManager()->getIdentifiers(), ['Module']
                            )
                        );
        }

        /**
         *
         * @var ApplicationInterface 
         */
        protected $application;

        /**
         * 
         * @return ApplicationInterface
         */
        public function getApplication() {
            return $this->application;
        }

        /**
         * 
         * @param ApplicationInterface $application
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

