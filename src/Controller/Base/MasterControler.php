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
            . 'Please update your code to use %s as parent class.', 
            MasterControler::class, 
            AbstractBaseController::class
    ), E_USER_DEPRECATED);

    /**
     * MasterControler
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015-2016, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license BSD
     * @deprecated since version 0.5.4-dev
     */
    class MasterControler extends AbstractBaseController {
        
    }

}