<?php

use Phalcon\Db\Adapter\Pdo\Sqlite;


/**  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
/*   -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
 *  Instanciate the dependency injector and define/load the core services required for the app to work
 */


// Initializing a DI Container
$di = new \Phalcon\DI\FactoryDefault();


/**
 * Overriding Response-object to set the Content-type header globally
 */
$di->setShared(
  'response',
  function () {
      $response = new \Phalcon\Http\Response();
      $response->setContentType('application/json', 'utf-8');

      return $response;
  }
);

/**
 * Make the config available throughout all the app & services via the di
 */
$di->setShared('config', $config);


/**
 * Databases & cache connectors
 * >> not using cache for this project
 */
$di->set("db",
  function () use ($config) {
      return $connection = new Sqlite((array)$config->get('sqlite'));
  }
);

//initialize the db connection.
$oDb = $di->getDb();


/**
 * Service to perform operations with the data
 * >> To separate controllers (API endpoints) & the core business logic (services)
 */

$di->setShared('recipeService', '\App\Services\RecipeService');


return $di;