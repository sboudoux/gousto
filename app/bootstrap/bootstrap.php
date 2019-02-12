<?php

// Loading app Configs
$config = require(__DIR__ . '/../config/config.php');


// Phalcon Autoloading classes - compatible with composer autoloader
require __DIR__ . '/../config/loader.php';


// Initializing application & the dependency injector ($di)
/** @var \Phalcon\DI\FactoryDefault $di */
$di = require __DIR__ . '/di.php';
$app = new \Phalcon\Mvc\Micro();
$app->setDI($di);


// Setting up routing
require __DIR__ . '/routes.php';


// load the API auth & response management
require __DIR__ . '/../api/auth.php';
require __DIR__ . '/../api/response.php';