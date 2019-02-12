
# README

## Gousto tech/coding test ?

- What am I asked to do?

Build a small, standalone, restful API. 

- What I believe is expected from me... 
  1. Showing my understanding of the technologies (php, restful API, ORM & data storage solution, MVC framework, unit-testing, API testing, composer, git... as much as tech and skills I can
  2. Showing quality code and a reliable app structure (clear segmentation, interfaces, MVC, SOLID, Dry code)
  3. showing I'm serious and commited about this test and willing to put hours of my personal time into this coding test.
  4. relying on framework and mainstream technologies so I don't build everything from scratch and spend too much time 
 
- Key technical aspects for this project (IMO):

  1. Performance: using a lightweight and performant framework
  2. Maintainable: implies mainstream language & technologies, easy to run/host, use of a popular framework, tested
  3. Production ready implies code quality, secure, moderate to high level of performance (with a question mark for not using a proper database engine)


## Technology & Decision making process

I could have used many different technologies and frameworks to build that API. My thoughts process was:

  - Node-based API: modern, event driven, but not my strongest skills and I could show better skills using PHP
  - Laravel or Symfony would have been the quickest and most mainstream option, but nothing original here. I would probably used composer a lot as the open source community has built everything for these.
  - SlimPhp: good candidate because it's lightweight and easy, PSR compliant, and I have used it for an oAuth2 server. But down the line, same as above. 
  - AWS APi gateway + Lambda: I thought about solutions that would reduce to a minimum the time allocate to building a dev environment and maximise the time coding the business logic you're asking for, but that is not very practical for a coding test.

But I have chosen PhalconPhp: 
  + extremely performant framework, perfect for a small API  (it's compiled, loaded in memory and cached as a php extension >> no access to the drive)
  + offers a "micro" mode -- stripped down from the router & "dispatcher" (- event management & advanced routing and forwarding options)
  + I have already have a VM ready with phalcon and php7.2 
  + PSR compliant
  + 
 
  - slightly harder for you to run the code, but down the line it's only require



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
 


##TODO / TO-NOT-FORGET

- Model setters  >> public 
- pagination
- unittest  --> testsuites
- postman 
- 204 
 