<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\Event\Mvc {

    use \Zend\Mvc\MvcEvent,
	\Zend\EventManager,
	\MNHcC\Helper\DynamicCoder;

    /**
     * ModuleMatchEvent
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    class ModuleMatchEvent extends MvcEvent implements ModuleMatchEventInterface{
	
	protected $module_name, $module;
	/**
	 * Constructor
	 *
	 * Accept a target and its parameters.
	 *
	 * @param  string $name Event name
	 * @param  string|object $target
	 * @param  array|ArrayAccess $params
	 * @throws Exception\InvalidArgumentException
	 */
	public function __construct($name = null, $target = null, $params = null) {
	    parent::__construct($name, $target, $params);
	}

	/**
	 * Set parameters
	 *
	 * Overwrites parameters
	 *
	 * @param  array|ArrayAccess|object $params
	 * @return Event
	 * @throws Exception\InvalidArgumentException
	 */
	public function setParams($params) {
	    parent::setParams($params);
	    if (isset($params['module']) === false) {
		throw new Exception\InvalidArgumentException('Event Parameter "module" (params["module"]) is not set');
	    } elseif (\is_object($params['module']) === false) {
		throw new Exception\InvalidArgumentException(
		sprintf('Event Parameter "module" (params["module"])  parameters must be an object; received "%s"',
			gettype($params))
		);
	    }
//	    $filter = new \Zend\Filter\PregReplace([
//		    'pattern'     => '~^set([A-Z].*)~',
//		    'replacement' => '$1'
//		]);
	    $refl = new \ReflectionObject($this);
	    
	    foreach ($params as $name => $value) {
		$setter = DynamicCoder::getSetterfromProperty($name);
	   
		if ($refl->hasMethod($setter)) {
		    $refl->getMethod($setter)->invoke($this, $value);
		}
	    }

//	    foreach (array_filter( (new \ReflectionClass(parent::class))->getMethods(\ReflectionMethod::IS_PUBLIC), 
//		    function(\ReflectionMethod $method) use($filter){
//		//$name = $filter->filter($method->getName());
//		$count = 0 ;
//		$name = preg_replace($filter->getPattern(), $filter->getReplacement(), $method->getName(), -1, $count);
//		if($count) {
//		   $method->keyname = strtolower($name);
//		   return true;
//		}
//		return false;
//		
//	    }) as $method){
//		/* @var $method \ReflectionMethod */
//		if(isset($params[$method->keyname])) {
//		    $args = [$params[$method->keyname] ];
//		    $method->invoke($this, ...$args);
//		}
//	    }
	    return $this;
	}
	

	/**
	 * 
	 * @return string get the name of Module
	 */
	public function getModuleName() {
	    return $this->getParam('modulename', null);
	}
	
	/**
	 * 
	 * @return Module get the matched Module
	 */
	public function getModule() {
	    return $this->getParam('module', null);
	}
	
	/**
	 * 
	 * @param string set the name of Module
	 * @return ModuleMatchEvent
	 */
	public function setModuleName($modulename) {
	    $this->module_name = $modulename;
	    return $this->setParam('modulename', $modulename);
	}
	
	/**
	 * 
	 * @param Module set the matched Module
	 * @return ModuleMatchEvent
	 */
	public function setModule($module) {
	    $this->module = $module;
	    return $this->setParam('module', $module)
		->setModuleNamefromObject($module);
	}
	
	public function setModuleNamefromObject($module) {
	    $modulerf = new \ReflectionObject($module);
	    return $this->setModuleName($modulerf->getNamespaceName());
	}

    }

}