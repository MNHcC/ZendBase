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
    use Zend\ServiceManager\ServiceLocatorInterface;
    use Zend\ServiceManager\AbstractPluginManager;
    use Zend\ServiceManager\ServiceManagerAwareInterface;
    use Zend\ServiceManager\ServiceLocatorAwareInterface;
    use MNHcC\Zend3bcHelper\ServiceManager\ServiceLocatorAwareControllerInterface;

    /**
     * MasterControlerTrait
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license BSD
     */
    trait AbstractBaseControllerTrait {

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
         * @param ModelInterface|\Traversable|array $viewModelParms
         * @return ModelInterface
         */
        public function createView($viewModelParms = []) {
            $viewClass = $this->getViewClass();
            return new $viewClass($this->getViewModelParms($this->viewToArray($viewModelParms)));
        }
        

       /**
         * 
         * @param ModelInterface|\Traversable|array $parms
         * @return array
         * @throws \InvalidArgumentException
         */
        public function getViewModelParms($parms = []) {
            try {
               $retVal = array_merge($this->viewModelParms, $this->viewToArray($parms)); 
            } catch (\InvalidArgumentException $exc) {
                throw new \InvalidArgumentException($exc->getMessage(), $exc->getCode(), $exc);;
            } finally {
                return $retVal;
            }
        }

        /**
         * 
         * @param ModelInterface|\Traversable|array $viewModelParms
         * @param bool $override
         * @return $this
         * @throws \InvalidArgumentException
         */
        public function setViewModelParms($viewModelParms, $override = false) {
            if ($override) {
                $this->viewModelParms = $this->viewToArray($viewModelParms);
            } else {
                $this->viewModelParms = array_merge($this->viewModelParms, $this->viewToArray($viewModelParms));
            }
            return $this;
        }

        /**
         * 
         * @param ModelInterface|\Traversable|array $view
         * @return array
         * @throws \InvalidArgumentException
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
         * @param mixed $view
         * @return boolean
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
         * @param string $viewClass the class of view and subclass of ModelInterface
         * @return $this
         * @throws \InvalidArgumentException
         */
        public function setViewClass($viewClass) {
            if (is_subclass_of($viewClass, ModelInterface::class)) {
                throw new \InvalidArgumentException(sprintf('view class must a subclass of %s. %s given!', ModelInterface::class, $viewClass));
            }
            $this->viewClass = $viewClass;
            return $this;
        }

        /**
         * get the main ServiceLocator when a PluginManager is used
         * @return ServiceLocatorInterface
         * @throws \BadMethodCallException
         * @throws \LogicException
         */
        public function getMainServicelocator() {
            if (!$this->hasServicelocator()) {
                throw new \BadMethodCallException( sprintf('Called a trait implemented method %s in %s thats require a getServiceLocator() method.' . PHP_EOL
                        . 'Implement one of this interfaces %s, %s or %s', 
                        __METHOD__, 
                        self::class, 
                        ServiceLocatorAwareInterface::class, 
                        ServiceLocatorAwareControllerInterface::class, 
                        ServiceManagerAwareInterface::class) );
            }

            if ($this instanceof ServiceManagerAwareInterface) {
                $sm = $this->getServiceManager();
            } else {
                $sm = $this->getServiceLocator();
            }
            if ($sm instanceof AbstractPluginManager) {
                $sm = $sm->getServiceLocator(); //get original
            }
            if(! $sm instanceof ServiceLocatorInterface){
                throw new \LogicException(sprintf('No ServiceLocator found! ServiceLocator musst from type %s, %s is given.'. PHP_EOL
                        . 'Is the controller initialized?', ServiceLocatorAwareInterface::class, (is_object($sm) ? get_class($sm) : gettype($sm)) ));
            }
            return $sm;
        }

        /**
         * check is ServiceLocator available
         * runn this for examble before call getMainServicelocator()
         * @return boolean
         */
        public function hasServicelocator() {
            return ($this instanceof ServiceLocatorAwareInterface 
                    || $this instanceof ServiceLocatorAwareControllerInterface 
                    || ($this instanceof ServiceManagerAwareInterface && method_exists($this, 'getServiceManager'))
                    || method_exists($this, 'getServiceLocator'));
        }

    }

}