<?php


//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
/* Manage API authentication

 We'll ensure the "client" is authenticated before accessing any data [production ready]
 Not having any reference to security and authentication in the test description, I'll go for a simple token-based auth.
 We'll look for a static token in the request header as we would -- with a more complex middleware -- for an oAuth2 authentication flow

 The token name and value are currently statically stored in teh $config file/object. Could be in .env, a constant... it doesn't matter much
 for such a basic implementation.

*/

$app->before(
    function () use ($app, $config) {

        $sToken = $app->request->getHeader($config->get('auth-token')['name']);
        if(empty($sToken) || $sToken !== $config->get('auth-token')['value']) {
            throw new App\Controllers\HttpExceptions\Http401Exception("Invalid auth token");
        }
    }
);


