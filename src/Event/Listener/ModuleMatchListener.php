<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MNHcC\Event\Listener {

    use Zend\EventManager\AbstractListenerAggregate;
    use Zend\EventManager\EventManagerInterface;
    use Zend\EventManager\EventManager;
    use Zend\EventManager\EventManagerAwareInterface;
    use Zend\Mvc\MvcEvent;
    use MNHcC\Event\Mvc\ModuleMatchEvent;
    use MNHcC\Helper\ObjectHelper;

    class ModuleMatchListener extends AbstractListenerAggregate {

	const MODULE_NAMESPACE = '__NAMESPACE__';
	const ORIGINAL_CONTROLLER = '__CONTROLLER__';

	/**
	 *
	 * @var EventManagerAwareInterface 
	 */
	protected $module;

	public function __construct(EventManagerAwareInterface $module) {
	    $this->setModule($module);
	}

	/**
	 * Attach to an event manager
	 *
	 * @param  EventManagerInterface $events
	 * @param  int $priority
	 */
	public function attach(EventManagerInterface $events, $priority = 1) {
	    $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH,
		    [$this, 'onDispatch'], $priority);
	}

	/**
	 * Listen to the "route" event and determine if the module namespace should
	 * be prepended to the controller name.
	 *
	 * If the route match contains a parameter key matching the MODULE_NAMESPACE
	 * constant, that value will be prepended, with a namespace separator, to
	 * the matched controller parameter.
	 *
	 * @param  MvcEvent $e
	 * @return null
	 */
	public function onDispatch(MvcEvent $e) {

	    if (!$e->getRouteMatch()) {
		return; //no route, no modul match
	    }

	    $module = $this->getModule();
	    $controller = $e->getRouteMatch()->getParam('controller');
	    $mod_rfl = new \ReflectionObject($module);
            
	    /* @var $eventManager EventManagerInterface */
	    $eventManager = $module->getEventManager();

	    if (!$eventManager instanceof EventManagerInterface) {
		$eventManager = new EventManager();
		$module->setEventManager($eventManager);
	    }

	    $eventManager->setIdentifiers(\array_merge(
			    $eventManager->getIdentifiers(),
			    [$mod_rfl->getShortName(), $mod_rfl->getName(), 'module']));
	    
	    /* @var $event ModuleMatchEvent */
	    $event = ObjectHelper::cast($e, ModuleMatchEvent::class);
            $event->setModule($module);
            $event->setViewModel($e->getViewModel());
            $event->setParam('view_model', $e->getViewModel());
            $event->setName(ModuleMatchEvent::EVENT_BEFORE_MODULE_MATCH);
            
            $eventManager->triggerEvent($event);

	    if (\strpos($controller, $mod_rfl->getNamespaceName(), 0) === 0) { //check the namespace
		//if this module
                $event->setName(ModuleMatchEvent::EVENT_MODULE_MATCH);
		$eventManager->triggerEvent($event);
	    }
	}

	/**
	 * 
	 * @return EventManagerAwareInterface
	 */
	public function getModule() {
	    return $this->module;
	}

	/**
	 * 
	 * @param EventManagerAwareInterface $module
	 * @return \MNHcC\Event\Listener\ModuleMatchListener
	 */
	public function setModule(EventManagerAwareInterface $module) {
	    $this->module = $module;
	    return $this;
	}

    }

}