<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\Controller\Base {

    use Zend\View\Model\ViewModel;

    /**
     * MasterControler
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    Interface MasterControlerInterface {

        /**
         * 
         * @param array $parms
         * @return array
         */
        public function getViewModelParms(array $parms = []);

        /**
         * 
         * @param array $viewModelParms
         * @param bool $overide
         * @return static
         */
        public function setViewModelParms(array $viewModelParms, $overide = false);

        /**
         * 
         * @param array $viewModelParms
         * @return ViewModel
         */
        public function getDefaultView(array $viewModelParms = []);

        /**
         * 
         * @param \Zend\View\Model\ViewModel|\Traversable|array $view
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
    }

}