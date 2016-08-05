<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\Service\Mvc\Template {

    use \MNHcC\Event\Mvc\ModuleMatchEventInterface,
	\Zend\EventManager\AbstractListenerAggregate,
	\Zend\EventManager\EventManagerInterface,
	\Zend\ServiceManager\ServiceLocatorAwareInterface,
	\Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * TemplateOverride
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    class TemplateOverrideService extends AbstractListenerAggregate implements ServiceLocatorAwareInterface {

	use ServiceLocatorAwareTrait;

	protected $Template, $NotFoundTemplate, $ExceptionTemplate;
	
	/**
	 *
	 * @var  \Zend\View\Model\ViewModel 
	 */
	protected $viewModel;
	
	/**
	 *
	 * @var \Zend\Mvc\View\Http\ViewManager
	 */
	protected $viewManager;

	const OVERRIDE_ALL = '*';
	const OVERRIDE_TEMPLATE = 'template';
	const OVERRIDE_NOT_FOUND_TEMPLATE = 'notfoundtemplate';
	const OVERRIDE_EXCEPTION_TEMPLATE = 'exceptiontemplate';
	const SERVICE_NAME = 'TemplateOverrideService';

	/**
	 * Attach to an event manager
	 *
	 * @param  EventManagerInterface $events
	 * @param  int $priority
	 */
	public function attach(EventManagerInterface $events, $priority = 1) {
	    $this->listeners[] = $events->attach(ModuleMatchEventInterface::EVENT_MODULE_MATCH,
		    [$this, 'onModuleMatch'], $priority);
	}

	public function set($type, $template) {
	    switch (strtolower($type)) {
		case self::OVERRIDE_TEMPLATE:
		    $this->setTemplate($template);
		    break;
		case self::OVERRIDE_NOT_FOUND_TEMPLATE:
		    $this->setNotFoundTemplate($template);
		    break;
		case self::OVERRIDE_EXCEPTION_TEMPLATE:
		    $this->setExceptionTemplate($template);
		    break;
		default:
		    break;
	    }
	}
	
	public function override() {
	    
	}

	public function loadFromConfig($name) {
	    $vm_conf = $this->getServiceLocator()->get('Config');
	    if( !isset($vm_conf['template_overrides']) ) {
		return;
	    } else {
		$conf = $vm_conf['template_overrides'];
	    }
	    
	    if(isset($conf[$name])){
		 $prefix = '';
		if(isset($conf[$name]['prefix'])) {
		    $prefix = $conf[$name]['prefix'] .'/';
		    unset($conf[$name]['prefix']);
		}
		    
		foreach ($conf[$name] as $override => $template) {
		    $this->set(\MNHcC\Helper\DynamicCoder::fromUnderscoreToCamelCase($override), $prefix.$template);
		}
	    }
	}

	public function onModuleMatch(ModuleMatchEventInterface $e) {
	    $this->setViewModel($e->getViewModel())
		    ->setViewManager($e->getApplication()
			->getServiceManager()
			->get('ViewManager'))
		    -> loadFromConfig($e->getModuleName());
	}

	/**
	 * 
	 * @return string
	 */
	public function getTemplate() {
	    return $this->Template;
	}

	/**
	 * 
	 * @return string
	 */
	public function getNotFoundTemplate() {
	    return $this->NotFoundTemplate;
	}

	/**
	 * 
	 * @return string
	 */
	public function getExceptionTemplate() {
	    return $this->ExceptionTemplate;
	}

	/**
	 * 
	 * @param string $Template
	 * @return \MNHcC\EventManager\TemplateChangeEventInterface
	 */
	public function setTemplate($Template) {
	    $this->Template = $Template;
	    $this->getViewModel()->setTemplate($Template);
	    return $this;
	}

	/**
	 * 
	 * @param string $NotFoundTemplate
	 * @return \MNHcC\EventManager\TemplateChangeEventInterface
	 */
	public function setNotFoundTemplate($NotFoundTemplate) {
	    $this->NotFoundTemplate = $NotFoundTemplate;
	    $this->getViewManager()->getRouteNotFoundStrategy()
		    ->setNotFoundTemplate($NotFoundTemplate);
	    return $this;
	}

	/**
	 * 
	 * @param string $ExceptionTemplate
	 * @return \MNHcC\EventManager\TemplateChangeEventInterface
	 */
	public function setExceptionTemplate($ExceptionTemplate) {
	    $this->ExceptionTemplate = $ExceptionTemplate;
	    $this->getViewManager()->getExceptionStrategy()
		    ->setExceptionTemplate($ExceptionTemplate);
	    return $this;
	}
	
	/**
	 * 
	 * @return \Zend\View\Model\ViewModel
	 */
	public function getViewModel() {
	    return $this->viewModel;
	}

	/**
	 * 
	 * @return \Zend\Mvc\View\Http\ViewManager
	 */
	public function getViewManager() {
	    return $this->viewManager;
	}

	/**
	 * 
	 * @param \Zend\View\Model\ViewModel $viewModel
	 * @return \MNHcC\Service\Mvc\Template\TemplateOverrideService
	 */
	public function setViewModel(\Zend\View\Model\ViewModel $viewModel) {
	    $this->viewModel = $viewModel;
	    return $this;
	}

	/**
	 * 
	 * @param \Zend\Mvc\View\Http\ViewManager $viewManager
	 * @return \MNHcC\Service\Mvc\Template\TemplateOverrideService
	 */
	public function setViewManager(\Zend\Mvc\View\Http\ViewManager $viewManager) {
	    $this->viewManager = $viewManager;
	    return $this;
	}

    	
    }

}
