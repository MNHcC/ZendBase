<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MNHcC\Controller;


/**
 * IndexController is a example implementation of the AbstractBaseController
 */
class IndexController extends Base\AbstractBaseController
{
    public function indexAction()
    {
        return $this->createView(['message'=>'Hello World!']);
    }
}
