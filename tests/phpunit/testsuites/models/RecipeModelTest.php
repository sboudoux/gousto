<?php

namespace Test\Phpunit;

class RecipeModelTest extends \Test\Phpunit\UnitTestCase
{

    public function testModelMetadataConsistency()
    {
        $this->setUp();
        $this->markTestSkipped("Since I am not using a ful model metadata definition, I can't test the model attributes as I would normally do. See sample code below ");

        /*
        $oRecipeModel = new \App\Models\Recipe();
        $oRecipeModel->initialize();

        $metaData = new Phalcon\Mvc\Model\MetaData\Memory();
        $attributes = $metaData->getAttributes($oRecipeModel);
        $asModelAttributes = array_keys($attributes);

        $this->assertTrue( isset($asModelAttributes['id']),  'No [ID] attribute in teh recipe model');
        $this->assertTrue( isset($asModelAttributes['created_at']), 'No [created_at] attribute in teh recipe modelo [ID] attribute in teh recipe model');
        $this->assertTrue( isset($asModelAttributes['updated_at']),  'No [updated_at] attribute in teh recipe model');
        $this->assertTrue( isset($asModelAttributes['box_type']),  'No [box_type] attribute in teh recipe model');
        $this->assertTrue( isset($asModelAttributes['title']),  'No [title] attribute in teh recipe model');
        // ... and so on for all the attributes
        */

    }

    public function testModelIsCuisineMethod()
    {
        $this->setUp();

        $oRecipeModel = new \App\Models\Recipe();
        $oRecipeModel->initialize();

        $this->assertFalse($oRecipeModel->isCuisineAvailable(''), 'RecipeModel::isCuisineAvailable did not return expected [false]');
        $this->assertFalse($oRecipeModel->isCuisineAvailable('it'), 'RecipeModel::isCuisineAvailable did not return expected [false]');
        $this->assertTrue($oRecipeModel->isCuisineAvailable('italian'), 'RecipeModel::isCuisineAvailable did not return expected [true]');
    }


    public function testModelValidationMethodSuccess()
    {
        $this->setUp();

        $oRecipeModel = new \App\Models\Recipe();
        $oRecipeModel->initialize();

        $oRecipeModel->id = 1;
        $oRecipeModel->title = 'Recipe title';
        $oRecipeModel->slug = 'recipe-slug';
        $oRecipeModel->recipe_cuisine = 'italian';
        $this->assertTrue($oRecipeModel->validation(), 'RecipeModel::validation did not return expected [true]');

        $oRecipeModel->id = null;
        $oRecipeModel->title = 'Recipe title';
        $oRecipeModel->slug = 'recipe-slug';
        $oRecipeModel->recipe_cuisine = 'italian';
        $this->assertTrue($oRecipeModel->validation(), 'RecipeModel::validation did not return expected [true]');
    }

    public function testModelValidationMethodFailure()
    {
        $this->setUp();

        $oRecipeModel = new \App\Models\Recipe();
        $oRecipeModel->initialize();


        $oRecipeModel->id = null;
        $oRecipeModel->title = '';
        $oRecipeModel->slug = 'recipe-slug';
        $oRecipeModel->recipe_cuisine = 'italian';
        $this->assertFalse($oRecipeModel->validation(), 'RecipeModel::validation did not return expected [false]');

        $oRecipeModel->id = null;
        $oRecipeModel->title = 'Recipe title';
        $oRecipeModel->slug = '';
        $oRecipeModel->recipe_cuisine = 'italian';
        $this->assertFalse($oRecipeModel->validation(), 'RecipeModel::validation did not return expected [false]');

        $oRecipeModel->id = null;
        $oRecipeModel->title = 'Recipe title';
        $oRecipeModel->slug = 'recipe-slug';
        $oRecipeModel->recipe_cuisine = 'French';
        $this->assertFalse($oRecipeModel->validation(), 'RecipeModel::validation did not return expected [false]');

    }



}