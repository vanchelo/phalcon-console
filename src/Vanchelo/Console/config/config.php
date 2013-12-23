<?php

return new \Phalcon\Config([
    'viewsDir' => __DIR__ . '/../views/',

    // Класс проверки прав доступа
    'check_access_class' => 'Vanchelo\Console\AccessCheck',

    // Проверка прав доступа по IP
    'check_ip' => true,

    'whitelist' => 'whitelist',
    'blacklist' => 'blacklist',


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
