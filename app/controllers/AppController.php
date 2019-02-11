<?php

namespace App\Controllers;

use App\Controllers\HttpExceptions\Http400Exception;
use App\Controllers\HttpExceptions\Http422Exception;
use App\Controllers\HttpExceptions\Http500Exception;
use App\Services\AbstractService;
use App\Services\ServiceException;
use App\Services\UsersService;

/**
 * Operations with Users: CRUD
 */
class AppController extends AbstractController
{
    /**
     * Catchall endpoint for all the /app/* request
     * @version 1.0
     * @access public - HTTP::All (map) 
     * @return Array 
    */
    public function notfoundAction()
    {
        
        throw new \App\Controllers\HttpExceptions\Http404Exception(
          _('API endpoint not available for the HTTP method you are using.'),
          \App\Controllers\AbstractController::ERROR_NOT_FOUND,
          new \Exception('URI not found: ' . $this->getDi()->getRequest()->getMethod() . ' ' . $this->getDi()->getRequest()->getURI())
        );
    }
    
    /**
     * Return a static message to inform the app is running
     * @version 1.0
     * @access public - HTTP::GET
     * @return Array 
     */
    public function infoAction(): string
    {
        return 'The app is running perfactly well';
    }
    
    
    /**
     * HTTP method test
     * @version 1.0
     * @access public - HTTP::GET
     * @return Array 
     */
    public function methodAction($arg0 = null, $arg1 = null, $arg20 = null): array
    {
        var_dump('====');
        $aGetData = $this->request->getRawBody();
        var_dump(" ==> row body", $aGetData); 
        var_dump(" ==> _GET", $_GET);
        var_dump(" ==> func param", $arg0, $arg1, $arg2); 
        var_dump(" ==> get[id]", $this->request->get('id')); 
        var_dump(" ==> Post[id]", $this->request->getPost('id')); 
        var_dump(" ==> put[id]", $this->request->getPut('id')); 
        
        var_dump(" ==> getQuery + sanit", $this->request->getQuery("id", null, 150));
        
        
        return ['some stuffs'];
    }
    
}
