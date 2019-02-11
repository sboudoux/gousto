<?php

use Phalcon\Db\Adapter\Pdo\Sqlite;

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

/** Make the config available throughout all the app & services via the di */
$di->setShared('config', $config);


/** Databases connectors */
$di->set("db",
  function () use ($config) {
      return $connection = new Sqlite([
            "dbname" => $config->get('sqlite')['dbname'],
        ]);
  }
);

//initialize the db connection.
$oDb = $di->getDb();


/** Service to perform operations with the recipes */
$di->setShared('usersService', '\App\Services\UsersService');
$di->setShared('recipeService', '\App\Services\RecipeService');

return $di;