<?php

// Define a new routing collection for each data type/model. 
// Starting with catchall/notfound using "map", followed by available routes for specific http methods 
// Sample here for a few static testign routes
$appCollection = new \Phalcon\Mvc\Micro\Collection();
$appCollection->setHandler('\App\Controllers\AppController', true);
$appCollection->setPrefix('/app');
$appCollection->map('', 'notfoundAction');
$appCollection->map('/{action}', 'notfoundAction');

$appCollection->get('/info', 'infoAction');
$appCollection->get('/status', 'infoAction');
$appCollection->map('/test/?{id:[0-9]{1,3}}', 'methodAction');
$app->mount($appCollection);


// -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =
// -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =
// Defines route for [  /recipe  ]
$recipeCollection = new \Phalcon\Mvc\Micro\Collection();
$recipeCollection->setHandler('\App\Controllers\RecipeController', true);
// Setup and prefix
$recipeCollection->setPrefix('/recipe');
$recipeCollection->map('', 'notfoundAction');
$recipeCollection->map('/{action}', 'notfoundAction');

//add, edit, fetch one
$recipeCollection->post('', 'addRecipeAction');
$recipeCollection->put('/{id:[1-9][0-9]*}', 'updateRecipeAction');
$recipeCollection->get('/{id:[1-9][0-9]*}', 'findRecipeAction');

// fetching multiple recipes
$recipeCollection->get('', 'getAllRecipeAction');
$recipeCollection->get('/cuisine/{cuisine:[a-z]{5,10}}', 'getAllRecipeAction');
$recipeCollection->get('/cuisine/{cuisine:[a-z]{5,10}}/?{page:[1-9][0-9]*}/?{nb:[1-9][0-9]*}', 'getAllRecipeAction');

//Rating
$recipeCollection->get('/{id:[1-9][0-9]*}/rate/{stars:[0-5]}', 'rateRecipeAction');
$recipeCollection->put('/{id:[1-9][0-9]*}/rate/{stars:[0-5]}', 'rateRecipeAction');
$app->mount($recipeCollection);


/*
// -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =
// -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =
// Defines route for [  /recipes  ]
$recipeCollection = new \Phalcon\Mvc\Micro\Collection();
$recipeCollection->setHandler('\App\Controllers\RecipeController', true);
//Setup and prefix
$recipeCollection->setPrefix('/recipes');
$recipeCollection->map('', 'notfoundAction');
$recipeCollection->map('/{action}', 'notfoundAction');

// fetching multiple recipes
$recipeCollection->get('', 'getAllRecipeAction');
$recipeCollection->get('/cuisine/{cuisine:[a-z]{5,10}}', 'getAllRecipeAction');
$recipeCollection->get('/cuisine/{cuisine:[a-z]{5,10}}/?{page:[1-9][0-9]*}/?{nb:[1-9][0-9]*}', 'getAllRecipeAction');
$app->mount($recipeCollection);
*/




// not found URLs
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
