<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\Event\Mvc {
    
    use \Zend\EventManager\EventInterface;

    /**
     * ModuleMatchEventInterface
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    Interface ModuleMatchEventInterface extends  EventInterface{

	const EVENT_MODULE_MATCH = 'module.match';
	const EVENT_BEFORE_MODULE_MATCH = 'before.module.match';
	/**
	 * 
	 * @return string the name of Module
	 */
	public function getModuleName();

	/**
	 * 
	 * @return Module the matched Module
	 */
	public function getModule();

	/**
	 * Get application instance
	 *
	 * @return \Zend\Mvc\ApplicationInterface
	 */
	public function getApplication();

	/**
	 * Get router
	 *
	 * @return Router\RouteStackInterface
	 */
	public function getRouter();

	/**
	 * Get route match
	 *
	 * @return null|Router\RouteMatch
	 */
	public function getRouteMatch();

	/**
	 * Get request
	 *
	 * @return \Zend\Http\Request
	 */
	public function getRequest();

	/**
	 * Get response
	 *
	 * @return \Zend\Stdlib\Response
	 */
	public function getResponse();

	/**
	 * Get the view model
	 *
	 * @return Model
	 */
	public function getViewModel();

	/**
	 * Get result
	 *
	 * @return mixed
	 */
	public function getResult();

	/**
	 * Retrieve the error message, if any
	 *
	 * @return string
	 */
	public function getError();

	/**
	 * Get the currently registered controller name
	 *
	 * @return string
	 */
	public function getController();

	/**
	 * Get controller class
	 *
	 * @return string
	 */
	public function getControllerClass();
    }

}
