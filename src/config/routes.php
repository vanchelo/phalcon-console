<?php
$router->addGet('/phalcon-console', [
    'module'     => null,
    'namespace'  => 'Vanchelo\Console\Controller',
    'controller' => 'Index',
    'action'     => 'index',
])->setName('console');

$router->addPost('/phalcon-console', [
    'module'     => null,
    'namespace'  => 'Vanchelo\Console\Controller',
    'controller' => 'Execute',
    'action'     => 'index',
])->setName('console_execute');
