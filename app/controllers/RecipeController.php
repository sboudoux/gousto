<?php

namespace App\Controllers;

//Rest & error management
use App\Controllers\HttpExceptions\Http400Exception;
use App\Controllers\HttpExceptions\Http500Exception;

//business logic
use App\Services\RecipeService;  // (currently not used, but here for reference)
use Phalcon\Filter;
use App\Models\Recipe as RecipeModel;

/**
 * Operations with recipe: CRU{D}
 */
class RecipeController extends AbstractController
{
    /**
     * Catchall endpoint for all the /recipe/* requests
     * @version 1.0
     * @access public - HTTP::All(map)
     * @return null
    */
    public function notfoundAction() : void
    {
        throw new \App\Controllers\HttpExceptions\Http404Exception(
          _('API endpoint not available for the HTTP method you are using.'),
          \App\Controllers\AbstractController::ERROR_NOT_FOUND,
          new \Exception('URI not found: ' . $this->getDi()->getRequest()->getMethod() . ' ' . $this->getDi()->getRequest()->getURI())
        );

    }
    
    
    // -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  
    // -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  
    // Recipe [single] related methods
    
    
    /**
     * Return one recipe identified by its ID in the csv/database
     * @version 1.0
     * @access public - HTTP::GET
     * @return \App\Models\Recipe 
     */
    public function findRecipeAction($piRecipeId) : ?\App\Models\Recipe
    {
        //DP: control parameters, ranges and http method
        if(empty($piRecipeId) || !is_numeric($piRecipeId)) {
            throw new Http400Exception("Bad parameters - Bad parameters - requires a positive integer ID ");
        }
        if(!$this->request->isGet()) {
            throw new Http400Exception("Bad HTTP method - requires updates to be made using POST ");
        }
        
        // Sanitize ecipe Id and fetch the record/model to return
        $iRecipeId = (int)$this->filter->sanitize($piRecipeId, 'int');
        $oRecipe = RecipeModel::findFirst($iRecipeId);
        if(empty($oRecipe)) {
            return null;
        }
                
        return $oRecipe;
    }

    
    /**
     * Update a recipe identified by its ID 
     * @version 1.0
     * @access public - HTTP::PUT/PATCH
     * @return \App\Models\Recipe 
     */
    public function updateRecipeAction($piRecipeId) : ?\App\Models\Recipe
    {
        //DP: control parameters, ranges and http method
        if(empty($piRecipeId) || !is_numeric($piRecipeId) || (int)$piRecipeId < 1) {
            throw new Http400Exception("Bad parameters - requires a positive integer ID ");
            return null;
        }
        if(!$this->request->isPut()) {
            throw new Http400Exception("Bad HTTP method - requires updates to be made using PUT ");
            return null;
        }
                
        // Basic validation of the Post data to ensure we have at least key/required values
        // help avoiding making the query below, loading models...  (assuming here the ID is required in the dataset)
        $iRecipeId = (int)$this->request->getPut('id', 'int', 0);
         if( $iRecipeId < 1) {
            throw new Http400Exception("Bad data - invalid or missing PUT/PATCH data [$iRecipeId]");
            return null;
        }

        // Fetch the Recipe to check it exists and get current record/data 
        $iRecipeId = (int)$this->filter->sanitize($piRecipeId, 'int');
        $oRecipe = RecipeModel::findFirst($iRecipeId);
        if(empty($oRecipe)) {
            return null;
        }
        
        // Load model with request data.
        // This allows partial updates if necessary... Validation is done at the model level, either manually as shown below
        // or automatically before update/create calls
        foreach($this->request->getPut() as $sParam => $vParamValue) {
            $oRecipe->{$sParam} = $vParamValue;
        }
        
        //We use the model validation to ensure data is valid & properly formatted
        if(!$oRecipe->validation()) {
            throw new Http400Exception("Bad parameters - data validation failed: ". $oRecipe->stringifyError());
            return null;
        }
        
        if(!$oRecipe->update()) {
            throw new Http500Exception("Server error - unable to save the recipe data ". $oRecipe->stringifyError());
            return null;
        }
        
        return $oRecipe;
    }
    
    /**
     * Add a new recipe to the database identified by its ID  in the database
     * @version 1.0
     * @access public - HTTP::POST
     * @return \App\Models\Recipe 
     */
    public function createRecipeAction() : ?\App\Models\Recipe
    {
        //DP: control parameters, ranges and http method
        if(!$this->request->isPost()) {
            throw new Http400Exception("Bad HTTP method - requires updates to be made using POST ");
        }
                
        // Basic validation of the Post data to ensure we have at least key/required values
        // help avoiding making the query below, loading models...  (assuming here only the title is required)
        $sRecipeTitle = (string)$this->request->getPut('title', 'string', '');
        if( mb_strlen($sRecipeTitle) < 5) {
            throw new Http400Exception("Bad data - invalid POST data ");
        }

        //No need to worry about the recipe ID here, on reate the model will remove it automatically
        $oRecipe = new RecipeModel();
        foreach($this->request->getPut() as $sParam => $vParamValue) {
           $oRecipe->{$sParam} = $vParamValue;
        }
        
        // Using the model validation, to ensure data is corret
        if(!$oRecipe->validation()) {
            //var_dump($oRecipe);
            throw new Http400Exception("Bad parameters - data validation failed: ". $oRecipe->stringifyError());
            return null;
        }
        
        if(!$oRecipe->create()) {
            throw new Http500Exception("Server error - unable to create the recipe ".$oRecipe->stringifyError());
            return null;
        }
        
        return $oRecipe;
    }




    /**
     * Rate a recipe identified by its ID
     * @version 1.0
     * @access public - HTTP::PUT/PATCH
     * @return \App\Models\Recipe
     */
    public function rateRecipeAction($piRecipeId, $piRating) : ?\App\Models\Recipe
    {
        //DP: control parameters, ranges and http method
        if(empty($piRecipeId) || !is_numeric($piRecipeId) || (int)$piRecipeId < 1) {
            throw new Http400Exception("Bad parameters - requires a positive integer ID ");
            return null;
        }
        if(!$this->request->isPut()) {
            throw new Http400Exception("Bad HTTP method - requires updates to be made using PUT ");
            return null;
        }


        $iRecipeId = (int)$this->filter->sanitize($piRecipeId, 'int');
        $iRating = (int)$this->filter->sanitize($piRating, 'int');
        $oRecipe = RecipeModel::findFirst($iRecipeId);
        if(empty($oRecipe)) {
            return null;
        }

        // I don't have anywhere to store the rating (not in the csv >> not in the db). I could add a column in the db, but then rating would be
        // similar to a partial update request...
        //So for this test sake, I'll return a successful response and add a "rating" attribute to the model without saving it
        $oRecipe->rating = $iRating;

        return $oRecipe;
    }

    
    
    
    
    
    
    // -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  
    // -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  -  =  -  
    // Recipe[S] related methods
    
    /**
     * Return all the recipe stored in the database
     * @version 1.0
     * @access public - HTTP::GET
     * @return Array 
     */
    public function getAllRecipeAction($psCuisineType = '', $psPageNumber = 1, $psNumberPerPage = 10) : ?array
    {
        //DP: control parameters, ranges and http method
        if(!$this->request->isGet()) {
            throw new Http400Exception("Bad HTTP method - requires updates to be made using GET ");
            return null;
        }

        // Mange pagination parameters:
        // PageNumber & NumberPerPage starts at 1. No point of having a page 0 or returning 0 records.
        $iPageNumber = ((int)$psPageNumber < 1) ? 1 : (int)$psPageNumber;
        $iNumberPerPage = ((int)$psNumberPerPage < 1) ? 10 : (int)$psNumberPerPage; 
        $aQueryParams = [
            'start' => ($iPageNumber-1) * $iNumberPerPage,
            'offset' => $iNumberPerPage,
        ];
        
        // Manage cuisine type filter
        if(!empty($psCuisineType)) {

            // Check the cuisine type is valid using the model
            $oRecipeModel = new RecipeModel();
            $psCuisineType = strtolower($psCuisineType);
            if(!$oRecipeModel->isCuisineAvailable($psCuisineType)) {
                throw new Http400Exception("Bad data - cuisine type [$psCuisineType] invalid ");
                return null;
            }

            $sQuery = 'SELECT * FROM App\Models\Recipe WHERE recipe_cuisine = :cType: ORDER BY id ASC LIMIT {start:int}, {offset:int} ';
            $aQueryParams['cType'] = $psCuisineType;
        } 
        else {
            $sQuery = 'SELECT * FROM App\Models\Recipe ORDER BY id ASC LIMIT {start:int}, {offset:int} ';
        }

        // Executing filtered and paginated query
        $oRecipes = $this->getDi()->get('modelsManager')->executeQuery($sQuery, $aQueryParams);
        if(empty($oRecipes)) {
             return null;
        }
        
        return $oRecipes->toArray();
    }
}
