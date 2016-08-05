<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace  MNHcC\Controller\Base { 
    
    use Zend\Mvc\Controller\AbstractActionController;
    /**
     * MasterControler
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    abstract class MasterControler extends AbstractActionController implements MasterControlerInterface{
	use MasterControlerTrait;
    }
}