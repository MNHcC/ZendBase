<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015-2016, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\Controller\Base {

    use Zend\View\Model\ModelInterface;
    
    /**
     * MasterControlerInterface
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015-2016, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license BSD
     */
    Interface AbstractBaseControllerInterface {

        /**
         * 
         * @param string $viewClass the class of view and subclass of ModelInterface
         * @return $this
         */
        public function setViewClass($viewClass);
        
        
        /**
         * 
         * @param ModelInterface|\Traversable|array $parms
         * @return array
         */
        public function getViewModelParms($parms = []);

        /**
         * 
         * @param ModelInterface|\Traversable|array $viewModelParms
         * @param bool $override
         * @return $this
         */
        public function setViewModelParms($viewModelParms, $override = false);

        /**
         * 
         * @param ModelInterface|\Traversable|array $view
         * @return array
         */
        public function viewToArray($view);

        /**
         * 
         * @param mixed $view
         * @return boolean
         */
        public function isView($view);
        
        
        /**
         * 
         * @param ModelInterface|\Traversable|array $viewModelParms
         * @return ModelInterface
         */
        public function createView($viewModelParms = []);
        
        /**
         * get the main ServiceLocator when a PluginManager is used
         * @return ServiceLocatorInterface
         */
        public function getMainServicelocator();
        
        /**
         * check is ServiceLocator available
         * runn this for examble before call getMainServicelocator()
         * @return boolean
         */
        public function hasServicelocator();
    }

}