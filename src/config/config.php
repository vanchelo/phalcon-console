<?php

return new \Phalcon\Config([
    'viewsDir' => __DIR__ . '/../views/',

    // If you want to specify the class test access rights to the console
    'check_access_class' => 'Vanchelo\Console\AccessCheck',

    // Check the permissions on the IP
    'check_ip' => false,

    /*
    |--------------------------------------------------------------------------
    | Console routes filter
    |--------------------------------------------------------------------------
    |
    | Set filter used for managing access to the console. By default, filter
    | 'whitelist' allows only people from 'whitelist' array below.
    |
    */

    'filter' => 'whitelist', // whitelist or blacklist

    /*
    |--------------------------------------------------------------------------
    | Enable console only for this locations
    |--------------------------------------------------------------------------
    |
    | Addresses allowed to access the console. This array is used in
    | 'whitelist' route filter. Nevertheless, this bundle should never
    | get nowhere near your production servers, but who am I to tell you how
    | to live your life :)
    |
    */

    'whitelist' => [
        '127.0.0.1',
        '::1'
    ],

    'blacklist' => [

    ],
]);
