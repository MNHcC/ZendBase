<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\View\Helper {

    use Zend\View\Helper\AbstractHelper;
    use Zend\Mvc\MvcEvent;
    use Zend\Mvc\Router\RouteMatch;
    use Zend\View\HelperPluginManager;

    /**
     * RouteMatchViewHelper
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    class RouteMatchViewHelper extends AbstractHelper {

        /**
         *
         * @var MvcEvent 
         */
        protected $mvcEvent;

        /**
         * 
         * @param MvcEvent $mvcEvent
         */
        public function __construct($sm, MvcEvent $mvcEvent) {
           //die(\Kint::dump($sm->get('url')));
            // injecting the mvc event, since $mvcEvent->getRouteMatch() may be null
            $this->mvcEvent = $mvcEvent;
        }

        /**
         * 
         * @return null|RouteMatch null on failure or a instance of RouteMatch
         */
        public function __invoke() {
            return $this->getMvcEvent()->getRouteMatch();
                    //->getRouteMatch();
        }

        /**
         * 
         * @return MvcEvent
         */
        public function getMvcEvent() {
            return $this->mvcEvent;
        }

        /**
         * 
         * @param MvcEvent $mvcEvent
         * @return $this
         */
        public function setMvcEvent(MvcEvent $mvcEvent) {
            $this->mvcEvent = $mvcEvent;
            return $this;
        }

    }

}
