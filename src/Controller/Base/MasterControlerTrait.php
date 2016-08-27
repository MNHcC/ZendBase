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

    use Zend\View\Model\ModelInterface;
    use Zend\View\Model\ViewModel;
    use Zend\Stdlib\ArrayUtils;
    use MNHcC\Controller\Base\MasterControlerInterface;
    use Zend\Mvc\Controller\AbstractActionController;

    /**
     * MasterControlerTrait
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    trait MasterControlerTrait {

        protected $viewModelParms = [];
        protected $viewClass = ViewModel::class;
     
        /**
         * 
         * {@inheritDoc}
         * Override of AbstractActionController::notFoundAction()
         */
        public function notFoundAction() {
            /* @var $result ViewModel */
            $result = parent::notFoundAction();
            $result->setVariables($this->getViewModelParms(), false);
            return $result;
        }

        /**
         * 
         * @deprecated since version 0.4.3-dev
         * @param array $viewModelParms
         * @return ViewModel
         */
        public function getDefaultView(array $viewModelParms = []) {
            trigger_error(sprintf('%s is deprecated please use %s::createView', __METHOD__, static::class), E_USER_DEPRECATED);
            return new ViewModel($this->getViewModelParms($viewModelParms));
        }

        /**
         * 
         * {@inheritDoc}
         * Implementation of MasterControlerInterface::createView()
         */
        public function createView($viewModelParms = []) {
            $viewClass = $this->getViewClass();
            return new $viewClass($this->getViewModelParms($this->viewToArray($viewModelParms)));
        }

        /**
         * 
         * {@inheritDoc}
         * Implementation of MasterControlerInterface::getViewModelParms()
         */
        public function getViewModelParms($parms = []) {
            return array_merge($this->viewModelParms, $this->viewToArray($parms));
        }

        /**
         * 
         * {@inheritDoc}
         * Implementation of MasterControlerInterface::setViewModelParms()
         */
        public function setViewModelParms($viewModelParms, $override = false) {
            if ($override) {
                $this->viewModelParms = $viewModelParms;
            } else {
                $this->viewModelParms = array_merge($this->viewModelParms, $viewModelParms);
            }
            return $this;
        }

        /**
         * 
         * {@inheritDoc}
         * Implementation of MasterControlerInterface::viewToArray()
         */
        public function viewToArray($view) {
            if ($this->isView($view)) {
                if (is_array($view)) {
                    /* @var $view array */
                    return $view;
                } elseif ($view instanceof ModelInterface) {
                    /* @var $view ModelInterface */
                    return $view->getVariables();
                } elseif ($view instanceof \Traversable) {
                    /* @var $view \Traversable */
                    return ArrayUtils::iteratorToArray($view);
                }
            } else {
                /* @ToDo Replace Exeption */
                throw new \InvalidArgumentException(sprintf('View must be one of these types: "%s"|"%s"|"array". "%s" given', ViewModel::class, \Traversable::class, is_object($view) ? get_class($view) : gettype($view)));
            }
        }

        /**
         * 
         * {@inheritDoc}
         * Implementation of MasterControlerInterface::isView()
         */
        public function isView($view) {
            return (bool) (is_array($view) || $view instanceof ModelInterface || $view instanceof \Traversable);
        }

        /**
         * 
         * @return string the class of view and subclass of ModelInterface
         */
        public function getViewClass() {
            return $this->viewClass;
        }

        /**
         * 
         * {@inheritDoc}
         * Implementation of MasterControlerInterface::setViewClass()
         */
        public function setViewClass($viewClass) {
            if (is_subclass_of($viewClass, ModelInterface::class)) {
                throw new \InvalidArgumentException(sprintf('view class must a subclass of %s. %s given!', ModelInterface::class, $viewClass));
            }
            $this->viewClass = $viewClass;
            return $this;
        }

    }

}