# APP structure

Please find below explanation regarding the app structure. It follows a standard MVC framework structure, using controllers for the API endpoints, models and services for business logic)
That structure is illustrated below: 

Entry point /public/index.php

```
/public/index.php 
    - /app/boostrap/bootstrap.php
      --> loads 
      [
             /app/config/config.php, 
             /app/config/loader.php, 
             /app/boostrap/di.php, 
             /app/boostrap/routes.php
             /app/api/auth.php
             /app/api/response.php
      ]
      
    --> handle request (based on routes)
       - /app/controllers/RecipeController.php
       
         --> Uses models
           - /app/models/Recipe.php
               - findRecipeAction   ("action" is a required suffix)
               - createRecipe
               - updateRecipe
               - rateRecipe
       
         --> shared business logic
           - /app/services/RecipeService.php  (currently empty)

--> manages Exceptions & errors

 ```

