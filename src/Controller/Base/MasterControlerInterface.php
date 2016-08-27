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

    use Zend\View\Model\ViewModel;
    use Zend\View\Model\ModelInterface;
    
    /**
     * MasterControler
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015-2016, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license BSD
     */
    Interface MasterControlerInterface {

        /**
         * 
         * @param string $viewClass the class of view and subclass of ModelInterface
         * @return $this
         * @throws \InvalidArgumentException
         */
        public function setViewClass($viewClass);
        
        
        /**
         * 
         * @param ModelInterface|\Traversable|array $parms
         * @return array
         * @throws \InvalidArgumentException
         */
        public function getViewModelParms($parms = []);

        /**
         * 
         * @param ModelInterface|\Traversable|array $viewModelParms
         * @param bool $override
         * @return $this
         * @throws \InvalidArgumentException
         */
        public function setViewModelParms($viewModelParms, $override = false);

        /**
         * 
         * @param ModelInterface|\Traversable|array $view
         * @return array
         * @throws \InvalidArgumentException
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
    }

}