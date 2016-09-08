<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015-2016, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\Controller\Base {

    trigger_error(sprintf(
            '%s is deprecated and will be removed in version 1.0.*. '
            . 'Please update your code to implement %s interface.', 
            MasterControlerInterface::class, 
            AbstractBaseControllerInterface::class
    ), E_USER_DEPRECATED);
        
    /**
     * MasterControlerInterface
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015-2016, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license BSD
     */
    Interface MasterControlerInterface extends AbstractBaseControllerInterface {
        
    }

}