<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\Helper {

    /**
     * ClassName
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    trait ClassName {
	public function getShortName(){
	    return self::sN();
	}
	
	static public function sN() {
	    return (string) (new \ReflectionClass(__CLASS__))->getShortName();
	}
    }

}
