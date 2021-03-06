<?php

namespace App\Models;

use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;

class Recipe extends \Phalcon\Mvc\Model
{
    /**
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=8, nullable=false)
     */
    private $id;

    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $created_at;

    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $updated_at;

    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $box_type;
    
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $title;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $slug;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $short_title;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $marketing_description;
    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    private $calories_kcal;
    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    private $protein_grams;
    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    private $fat_grams;
    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    private $carbs_grams;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $bulletpoint1;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $bulletpoint2;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $bulletpoint3;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $recipe_diet_type_id;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $season;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $base;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $protein_source;
    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    private $preparation_time_minutes;
    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    private $shelf_life_days;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $equipment_needed;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $origin_country;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $recipe_cuisine;
    /**
     *
     * @var string
     * @Column(type="text", length=255, nullable=true)
     */
    private $in_your_box;
    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=false)
     */
    private $gousto_reference;



    // Should be build dynamically from the database or a pre-defined list of cuisine
    // A static list is plenty enough here to manage validation and filtering.
    private $casAvailableCuisine = ['asian', 'british', 'italian', 'mediterranean', 'mexican'];


    /**
     * I sadly cannot type parameters here (using php7.2) as the declaration would conflict with Phalcon one.
     * @param $property
     * @return mixed
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }


    /**
     * Stringify the messages stored in the model
     * @param string $psGlue
     * @return string
     */
    public function stringifyError(string $psGlue = " | ") : string
    {
        return implode($psGlue, $this->getMessages());
    }

    /**
     * Overwrite Phalcon's toArray method to give the ability to add extra data to the model
     * (to manage rating [not currently in the db] or calculated values)
     * @return array
     */
    public function toArray($columns = NULL)
    {
        $aModelData = parent::toArray();

        $aObjectVars = get_object_vars($this);
        $diff = array_diff_key($aObjectVars, $aModelData);

        $oManager = $this->getModelsManager();
        foreach($diff as $key => $value) {
            if($oManager->isVisibleModelProperty($this, $key)) {
                $aModelData += [$key => $value];
            }
        }
        return $aModelData;
    }
    
    /**
     * Check if a cuisine type is available
     * @param string $psCuisine
     * @return bool
     */
    public function isCuisineAvailable(string $psCuisine) : bool
    {
        if(empty($psCuisine)) {
            return false;
        }

        if(in_array($psCuisine, $this->casAvailableCuisine)) {
            return true;
        }
        
        return false;
    }



    /**
     * Initialize method for model.
    */
    public function initialize()
    {
        //Allow partial model updates
        $this->useDynamicUpdate(true);
        
        // define model relations if necessary
        // > none here
    }

    /**
     * Returns table name mapped in the model.
     * @return string
    */
    public function getSource()
    {
        return 'recipe';
    }
    
    
    
    /**
     * Use db/model event handler to automatically validate the model data on save/update
     * Can also been launched manually for data validation
     *
     * NOTE: since I'm only using simple models (without metadata, type/bindings, required options...),
     * I'll make this validation method very basic
     *
     * @return boolean
    */
    public function validation() : bool
    {
        $bValidated = true;
        
        // This test needs to work for create & update
        if(isset($this->id) && (int)$this->id < 1) {
            $bValidated = false;
            $this->appendMessage(new Message('recipe ID is not valid'));
        }
        
        if(empty($this->title) || mb_strlen($this->title) < 5) {
            $bValidated = false;
            $this->appendMessage(new Message('recipe TITLE is not valid'));
        }
        
        if(empty($this->slug) || mb_strlen($this->slug) < 5 || mb_strlen($this->slug) > 64) {
            $bValidated = false;
            $this->appendMessage(new Message('recipe SLUG is not valid'));
        }
        
        if(empty($this->recipe_cuisine) || mb_strlen($this->recipe_cuisine) < 5 || mb_strlen($this->recipe_cuisine) > 64) {
            $bValidated = false;
            $this->appendMessage(new Message('recipe RECIPE_CUISINE is not valid'));
        }
        if(!$this->isCuisineAvailable($this->recipe_cuisine)) {
            $bValidated = false;
            $this->appendMessage(new Message('recipe RECIPE_CUISINE is not matching any category'));
        }


        // And so on x23 columns. I believe this is not necessary for this test
        // NOTE: I have only focused here on the attributes/columns relevant for this test (id, title, and cuisine type)
        //TODO: check other fields/columns
        //TODO: check other fields/columns
        //TODO: check other fields/columns
        //TODO: check other fields/columns
        
        return $bValidated;
    }    
    
    /**
     * Use db/model event handler to automatically add a creation date to model/record before creating a record
     * @return boolean
    */
    public function beforeValidationOnCreate() : bool
    {
        $this->id = null;
        $this->created_at = date('d/m/Y H:i:s');
        $this->updated_by = null;
        return true;
    }

    /**
     * Use db/model event handler to automatically add a update date to model before updating a record
     * @return boolean
    */
    public function beforeValidationOnUpdate() : bool
    {
        $this->updated_by = date('Y-m-d H:i:s');
        return true;
    }
    


      

    
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}