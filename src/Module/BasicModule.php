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

    use Zend\EventManager\EventInterface;
    use Zend\EventManager\EventManagerAwareTrait;
    use Zend\EventManager\EventManagerInterface;
    
    use MNHcC\Zend3bcHelper\ServiceManager\ServiceLocatorAwareTrait;
    use MNHcC\Event\Listener\ModuleMatchListener;
    use MNHcC\Module\BasicModuleInterface;

    /**
     * BasicModule
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    abstract class BasicModule implements BasicModuleInterface {

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
            return $this->setEventManagerTrait($events)
                ->getEventManager()
                ->setIdentifiers(\array_merge(
                    $this->getEventManager()->getIdentifiers(), ['Module']
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
        public function setApplication(\Zend\Mvc\ApplicationInterface $application) {
            $this->application = $application;
            return $this;
        }

        /**
         * Listen to the bootstrap event end register the ModuleMatchListener
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