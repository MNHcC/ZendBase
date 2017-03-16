<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC {

    use Zend\EventManager\EventInterface;
    use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
    use Zend\View\HelperPluginManager as ViewHelperPluginManager;
    use MNHcC\View\Helper\RouteMatchViewHelper;
    use MNHcC\Module\BasicModule;

    /**
     * The init module for the ZendBase project 
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    class Module extends BasicModule implements ViewHelperProviderInterface {

        /**
         * Listen to the bootstrap event
         *
         * @param EventInterface $e
         * @return array
         */
        public function onBootstrap(EventInterface $e) {
            parent::onBootstrap($e);
        }

//	public function onDispatch(MvcEvent $e) { //set template fals controller nicht gefunden
//	    $this->getEventManager()->trigger(
//		    $e->setName(ModuleMatchEvent::EVENT_BEFORE_MODULE_MATCH)
//		    ->setParam('module', $this));
//	}

        public function getViewHelperConfig() {
            return [
                'factories' => [
                    'routeMatch' => function(ViewHelperPluginManager $sm) {
                        return new RouteMatchViewHelper($sm, $sm->getServiceLocator()
                                        ->get('Application')
                                        ->getMvcEvent()
                        );
                    }],
            ];
        }

    }

}
    
