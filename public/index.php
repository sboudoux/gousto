<?php

use App\Controllers\AbstractHttpException;

try {

    // Boostrapping the app, loading config and phalcon core services
    $config = require(__DIR__ . '/../app/bootstrap/bootstrap.php');

    // Processing request
    $app->handle();
        
} 
catch (AbstractHttpException $e) {
    $response = $app->response;
    $response->setStatusCode($e->getCode(), $e->getMessage());
    $response->setJsonContent($e->getAppError());
    $response->send();
} 
catch (\Phalcon\Http\Request\Exception $e) {
    $app->response->setStatusCode(400, 'Bad request')
        ->setJsonContent([
          AbstractHttpException::KEY_CODE    => 400,
          AbstractHttpException::KEY_MESSAGE => 'Bad request'
        ])
        ->send();
}
catch (\Phalcon\Http\Request\Exception $e) {
    $app->response->setStatusCode(400, 'Bad request')
        ->setJsonContent([
            AbstractHttpException::KEY_CODE    => 400,
            AbstractHttpException::KEY_MESSAGE => 'Bad request'
        ])
        ->send();
}
catch (\Exception $e) {
    
    
    // Managing here serious framework errors 
    if(empty($config) || empty($app) ) {
        var_dump("Fatal service error", $e);
        exit('Framework initialisation error');
    }
    
    // DEVEL/DEBUGGING: managing here all other types of errors (use debug config)
    if($config->get('runtime') && $config->get('runtime')['display_errors']) {
        echo "<pre>";
        var_dump("Runtime error", $e);
    } 
    else {
        
        // Standard error response
        $result = [
            AbstractHttpException::KEY_CODE    => 500,
            AbstractHttpException::KEY_MESSAGE => 'Some error occurred on the server.'
        ];

        // Sending error response
        $app->response->setStatusCode(500, 'Internal Server Error')->setJsonContent($result)->send();
    }
}
