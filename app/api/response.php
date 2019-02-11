<?php


//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
/* Response management : encoding & error

 We need to processs the controller/service responses o the API always return the correct/json-encoded answer
 In real scenario, I would build an automatic entity conversion based on model structure/metadata, but to not spend too much time on this test, I will simply
 convert a few specific data types to json.

 Data I will consider correct and return as json: scalar, recipe models, and arrays of models.
 Anything empty response from the controller will lead to a HTTP-204
 Anything else will be considered an error Exception('Bad Response');


*/

$app->after(
    function () use ($app) {
        // Getting the return value of method
        $vReturnData = $app->getReturnedValue();


        // Convert models to array using Phalcon internal method (avoid issues with circular references)
        // Allows the controller to return directly models/entities with the bare minimum amount of processing
        if (is_a($vReturnData, 'App\Models\Recipe')) {
            $vReturnData = $vReturnData->toArray();
        }

        if (empty($vReturnData)) {
            // Successful response without any content
            $app->response->setStatusCode('204', 'No Content');
        }
        elseif (is_array($vReturnData) || is_scalar($vReturnData)) {
            // Transforming arrays to JSON
            $app->response->setContent(json_encode($vReturnData));

        } else {
            // Unexpected response: not empty, but neither an array or one of the expected model
            throw new Exception('Bad Response');
        }

        // Sending response to the client
        $app->response->send();
    }
);