<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MNHcC\TESTING {

    // use the namespace of modules 
    use MNHcC;

return [
        'modules' => [
            MNHcC::class,
        ],
        // These are various options for the listeners attached to the ModuleManager
        'module_listener_options' => [
            // This should be an array of paths in which modules reside.
            // If a string key is provided, the listener will consider that a module
            // namespace, the value of that key the specific path to that module's
            // Module class.
            'module_paths' => [
                '../../vendor',
            ],
        ],
    ];
}