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

    use Zend\Mvc\Controller\AbstractActionController;
    use MNHcC\Zend3bcHelper\ServiceManager\ServiceLocatorAwareTrait;
    use MNHcC\Zend3bcHelper\ServiceManager\ServiceLocatorAwareControllerInterface;

    /**
     * AbstractBaseController
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    abstract class AbstractBaseController extends AbstractActionController implements AbstractBaseControllerInterface, ServiceLocatorAwareControllerInterface {
        use AbstractBaseControllerTrait;
        use ServiceLocatorAwareTrait;
    }

}