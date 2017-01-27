<?php

/**
 * MNHcC/ZendBase https://github.com/MNHcC/ZendBase
 *
 * @link      https://github.com/MNHcC/ZendBase for the canonical source repository
 * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
 * @license BSD
 */

namespace MNHcC\Helper {

    /**
     * DynamicCoder
     *
     * @author MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @copyright 2015, MNHcC  - Michael Hegenbarth (carschrotter) <mnh@mn-hegenbarth.de>
     * @license default
     */
    abstract class DynamicCoder {

        /**
         * 
         * @param string $name
         * @return string
         */
        static public function getSetterfromProperty($name, $camelcase=true) {
            return 'set' . self::fromUnderscoreToCamelCase($name, '-');
        }

        /**
         * 
         * @param string $name
         * @param string $char_to_change,... unlimited OPTIONAL number of additional chars to replache to camelcase
         * @return string
         */
        static public function fromUnderscoreToCamelCase($name, ...$chars_to_change) {
            $chars_to_change = \array_merge($chars_to_change, ['_']);
            $search = [];
            $replache = [];
            foreach ($chars_to_change as $char) {
                $search[] = $char;
                $replache[] = ' ';
            }
            return \str_replace(' ', '', \ucwords(\str_replace($search, $replache, $name)));
        }

        /**
         * Convert a CameCase string to underscore seperated string
         * <code>
         * <?php
         * \MNHcC\Helper\DynamicCoder::fromCamelCaseToUnderscore('CamelCaseString'); //return camel_case_string
         * \MNHcC\Helper\DynamicCoder::fromCamelCaseToUnderscore('CamelCaseString', '-'); //return camel-case-string
         * </code>
         * @param string $name the name or key to underscore
         * @param string $underscore (optional) default '_' You can change optional the underscore to another sing for example a hyphen (-)
         * @return string the underscored name
         */
        static public function fromCamelCaseToUnderscore($name, $underscore = '_') {
            return \strtolower(\preg_replace('/([a-z])([A-Z])/', '$1'.$underscore.'$2', $name));
        }

    }

}
