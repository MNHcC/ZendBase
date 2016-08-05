<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MNHcC\Controller\Base { 

    /**
     * MasterControlerTrait
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    trait MasterControlerTrait {
	protected $viewModelParms = [];	
	
	public function notFoundAction() {
	    
	    /* @var $result \Zend\View\Model\ViewModel */
	    $result = parent::notFoundAction();
	    $result->setVariables($this->getViewModelParms(), false);
	    return $result;
	}

	public function onDispatch(\Zend\Mvc\MvcEvent $e) {
	    return parent::onDispatch($e);
	}
	
	/**
	 * 
	 * @param array $viewModelParms
	 * @return \Zend\View\Model\ViewModel
	 */
	public function getDefaultView(array $viewModelParms = []){
	    return new \Zend\View\Model\ViewModel($this->getViewModelParms($viewModelParms));
	}
		
	/**
	 * 
	 * @param array $parms
	 * @return array
	 */
	public function getViewModelParms(array $parms = []){
	    return array_merge($this->viewModelParms, $parms);
	}
	
	/**
	 * 
	 * @param array $viewModelParms
	 * @param bool $overide
	 * @return static
	 */
	public function setViewModelParms(array $viewModelParms, $overide = false) {
	    if($overide){
		$this->viewModelParms = $viewModelParms;
	    } else {
		$this->viewModelParms = array_merge($this->viewModelParms, $viewModelParms);
	    }
	    return $this;
	}
	
	/**
	 * 
	 * @param \Zend\View\Model\ViewModel|\Traversable|array $view
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function viewToArray($view){
	    if(is_array($view)){
		return $view;
	    } elseif($view instanceof \Zend\View\Model\ViewModel){
		return $view->getVariables();
	    } elseif($view instanceof \Traversable) {
		return \Zend\Stdlib\ArrayUtils::iteratorToArray($view);
	    }
	    /* @ToDo Replace Exeption */
	    throw new \InvalidArgumentException(sprintf('View must be one of these types: "%s"|"%s"|"array". "%s" given',  \Zend\View\Model\ViewModel::class, \Traversable::class,  is_object($view) ? get_class($view) : gettype($view)));
	}
	
	/**
	 * 
	 * @param mixed $view
	 * @return boolean
	 */
	public function isView($view){
	    return  (bool) (is_array($view) || $view instanceof \Zend\View\Model\ViewModel || $view instanceof \Traversable);
	}
	
    }
}