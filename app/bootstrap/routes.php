<?php

/**  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
/*   -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
 *  Use Phalcon Micro router to create API endpoints & manage HTTP request types
 */


/**
 * Test routes to ensure the framework work as expected (dev & test purposes)
 * /app/info or /app/status  GET
 * /app/test  MAP (all)
 */
$appCollection = new \Phalcon\Mvc\Micro\Collection();
$appCollection->setHandler('\App\Controllers\AppController', true);
$appCollection->setPrefix('/app');
$appCollection->map('', 'notfoundAction');
$appCollection->map('/{action}', 'notfoundAction');

$appCollection->get('/info', 'infoAction');
$appCollection->get('/status', 'infoAction');
$appCollection->map('/test/?{id:[0-9]{1,3}}', 'methodAction');
$app->mount($appCollection);



/**
 * -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =
 *
 * Defining here routes for [ /recipe ] endpoints
 *
 */

$recipeCollection = new \Phalcon\Mvc\Micro\Collection();
$recipeCollection->setHandler('\App\Controllers\RecipeController', true);

// Setup and prefix
$recipeCollection->setPrefix('/recipe');
$recipeCollection->map('', 'notfoundAction');
$recipeCollection->map('/{action}', 'notfoundAction');

//add, edit, fetch one
$recipeCollection->post('', 'createRecipeAction');
$recipeCollection->put('/{id:[1-9][0-9]*}', 'updateRecipeAction');
$recipeCollection->get('/{id:[1-9][0-9]*}', 'findRecipeAction');

// fetching multiple recipes
// (assuming cuisine types are string between 5 & 32 char long based on csv data)
$recipeCollection->get('', 'getAllRecipeAction');
$recipeCollection->get('/cuisine/{cuisine:[a-z]{3,32}}', 'getAllRecipeAction');
$recipeCollection->get('/cuisine/{cuisine:[a-z]{3,32}}/?{page:[1-9][0-9]*}/?{nb:[1-9][0-9]*}', 'getAllRecipeAction');

//Rating
$recipeCollection->get('/{id:[1-9][0-9]*}/rate/{stars:[0-5]}', 'rateRecipeAction');
$recipeCollection->put('/{id:[1-9][0-9]*}/rate/{stars:[0-5]}', 'rateRecipeAction');
$app->mount($recipeCollection);



// not found URLs >> Exception
$app->notFound(
  function () use ($app) {
      $exception =
        new \App\Controllers\HttpExceptions\Http404Exception(
          _('URI not found or error in request.'),
          \App\Controllers\AbstractController::ERROR_NOT_FOUND,
          new \Exception('URI not found: ' . $app->request->getMethod() . ' ' . $app->request->getURI())
        );
      throw $exception;
  }
);
