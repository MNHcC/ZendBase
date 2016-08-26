<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\Service\Mvc\Controller {

    use Zend\ServiceManager\AbstractFactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    /**
     * CommonControlAppAbstractFactory
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    class CommonControlAppAbstractFactory implements AbstractFactoryInterface {

        const CLASS_NAME_PART = 'Controller';

        /**
         *  save state of service
         * @var array 
         */
        protected $cache = [];

        public function canCreate(\Interop\Container\ContainerInterface $container, $requestedName) {
            return $this->canCreateServiceWithName($container, $requestedName, $requestedName);
        }

        public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, mixed $options = null) {
            return $this->createServiceWithName($container, $requestedName, $requestedName);
        }

        public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName) {
            $controller = $requestedName . static::CLASS_NAME_PART;

            if ($this->checkEndlessLoop($controller, __FUNCTION__)) {
                return false;
            }

            if (($result = $this->getCache($name)) !== null) {
                return $result;
            } else {
                $this->setCachEntry($name, false);
            }
            // check is a factory or invokable whit controler class name

            if (class_exists($controller) or $locator->has($controller)) {
                $this->setCachEntry($name, true);
                return true;
            }

            return false;
        }

        /**
         * 
         * @param string $controller
         * @param string  $func
         * @return boolean
         */
        public function checkEndlessLoop($controller, $func) {
            // check is the CLASS_NAME_PART a second added
            if (strpos($controller, \str_repeat(static::CLASS_NAME_PART, 2))) {
                $backtrace = debug_backtrace();
                //search on backtrace a call of the function on this class
                foreach ($backtrace as $stepp) {
                    if (isset($stepp['class']) && isset($stepp['function']) && ($stepp['class'] == static::class && $stepp['function'] == $func)) {
                        return true;
                    }
                }
            }
            return false;
        }

        public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName) {
            $controller = $requestedName . static::CLASS_NAME_PART;
            // check is a factory or invokable whit controler class name
            if ($locator->has($controller)) {
                return $locator->get($controller);
            }

            return (new \ReflectionClass($controller))->newInstance($locator);
        }

        /**
         * 
         * @param string $entry Optional
         * @return bool[]
         */
        public function getCache($entry = null) {
            if ($entry) {
                return isset($this->cache[$entry]) ? $entry : null;
            }
            return $this->cache;
        }

        /**
         * 
         * @param string $entry
         * @param bool $flag
         */
        public function setCachEntry($entry, $flag) {
            $this->cache[$entry] = (bool) $flag;
        }

        /**
         * 
         * @param bool[] $cache
         * @return \MNHcC\Service\Mvc\Controller\CommonControlAppAbstractFactory
         */
        public function setCache($cache) {
            $this->cache = $cache;
            return $this;
        }

    }

}
