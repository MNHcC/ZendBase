<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\View\Helper {

    use Zend\View\Helper\AbstractHelper;

    class DisplayCurrentDate extends AbstractHelper {

        public function __invoke($format = 'd.m.Y') {
            return date($format);
        }

    }

}