<?php


//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
//  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -
/**
 * Response management : encoding & error

 We need to process the controller/service responses so the API always return the correct/json-encoded response.
 In real scenarios, I would build the entity conversion/encoding directly based on model data structure using metadata, but to not spend too much time on this test, I will simply
 convert the RecipeModel to json.

 Data the API will consider valid to return as json: scalar, array, recipe models
 Any empty response from the controller will lead to a HTTP-204
 Anything else will be considered an error Exception('Bad Response');

 *
 */

$app->after(
    function () use ($app) {
        // Fetched data returned by the controllers
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
            // Converting data to JSON
            $app->response->setContent(json_encode($vReturnData));

        } else {
            // Unexpected response: not empty, but neither an array or one of the expected model
            throw new Exception('Bad Response');
        }

        // Sending HTTP response to the client
        $app->response->send();
    }
);