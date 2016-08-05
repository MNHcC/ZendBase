<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\View\Helper {

    use \Zend\View\Helper\AbstractHelper,
	\Zend\Mvc\MvcEvent;
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

	public function __construct(\Zend\Mvc\MvcEvent $mvcEvent) {
	    // injecting the mvc event, since $mvcEvent->getRouteMatch() may be null
	    $this->mvcEvent = $mvcEvent;
	}

	/**
	 * 
	 * @return null|Router\RouteMatch
	 */
	public function __invoke() {
	    return $this->getMvcEvent()->getRouteMatch();
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
	 * @return \MNHcC\View\Helper\RouteMatchViewHelper
	 */
	public function setMvcEvent(MvcEvent $mvcEvent) {
	    $this->mvcEvent = $mvcEvent;
	    return $this;
	}

    	
    }

}
