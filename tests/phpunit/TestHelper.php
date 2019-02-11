<?php

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", __DIR__);

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// Required for phalcon/incubator
require_once __DIR__ . "/../../vendor/autoload.php";

require_once(ROOT_PATH . '/UnitTestCase.php');
require_once(ROOT_PATH . '/ModelTestCase.php');
require_once(ROOT_PATH . '/FunctionalTestCase.php');

var_dump( spl_autoload_call('App\Controllers\RecipeController' ) );

// Use the application autoloader to autoload the classes
// Autoload the dependencies found in composer
$loader = new Loader();

/*$loader->registerDirs(
    [
        ROOT_PATH,
        '/srv/www/phalconApi/app',
        '/srv/www/phalconApi/app/controllers'
    ]
);*/

$loader->registerNamespaces(
    [
        'App\Controllers'    => '/srv/www/phalconApi/app/controllers',
        'Tests\Phpunit' => ROOT_PATH,
        'Phalcon\Test' => '/srv/www/phalconApi/vendor/phalcon/incubator/Library/Phalcon/Test/',
        'SebastianBergmann' => '/srv/www/phalconApi/vendor/sebastian',
        'App\Models' => '/srv/www/phalconApi/app/models',
    ]
);
/*  Alternatives to load files using phalcon loader
$loader->registerDirs(
$loader->registerClasses(
$loader->registerFiles(
*/

$loader->register();



$di = new FactoryDefault();
Di::reset();

Di::setDefault($di);

