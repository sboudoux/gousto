## Defensive programming

Adept of defensive programming, you will see I ensure functions/methods validate parameters. I will also try to consistently and explicitly return the correct data type even when an exception is thrown. 
That is a bit bothersome, but significantly improve security and reduces chances for potential bugs.  

RELATED NOTES: 
  1. I could have used Phalcon "full mode" (advanced routing + event management with the dispatcher) to have advanced parameter management and annotations. That would have taken significantly longer to configure the framework and routes, and also reduced performances.   
  But considering the small size of this project, I'll stick to the micro mode and will test parameter manually in the RecipeController.

  2. without the full router and annotations, I sadly can't leverage all he potential of php7.2 and type my parameters (passed as string). That doesn't impact much the code, but that means I'll also have to test numeric values are typed properly



## Naming convention

I'm used to code using the hungarian notation, or at least a PHP-specific version of it. (https://en.wikipedia.org/wiki/Hungarian_notation)
In a nutshell, I prefix my variables and parameters with a letter for the scope and/or the type. Less impactful now we can enforce types and return types in php7.1 and even more in 7.2, it's still in my opinion help improving code readability if used consistently. 
Ihat simply means: 

  - a recipe ID variable will be named $iRecipeId  (i for integer),
  - a recipe title $sRecipeTitle (s for string), 
  - or as a parameter $psRecipeTitle (p for parameter, s for string)
  - an array define as a class attribute;  $caRecipes  (c for class, a for array)   
  ...
 