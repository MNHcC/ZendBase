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

    trigger_error(sprintf(
            '%s is deprecated and will be removed in version 1.0.*. '
            . 'Please update your code to use the %s trait', 
            MasterControlerTrait::class, 
            AbstractBaseControllerTrait::class
    ), E_USER_DEPRECATED);
    
    /**
     * MasterControlerTrait
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    trait MasterControlerTrait {

        use AbstractBaseControllerTrait;
        
    }

}