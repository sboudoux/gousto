<?php


//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
/* Manage API authentication

 Please refer to /doc/auh.md  for more details
 */

$app->before(
    function () use ($app, $config) {

        $sToken = $app->request->getHeader($config->get('auth-token')['name']);
        if(empty($sToken) || $sToken !== $config->get('auth-token')['value']) {
            throw new App\Controllers\HttpExceptions\Http401Exception("Invalid auth token");
        }
    }
);


