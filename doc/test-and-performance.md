# Basic CMD testing and performance benchmark

Since I need to create  a production ready API, I have to test & benchmark it. 
I'm describing here how I've done that very quickly.



##Initial test with Curl
Find here a few command lines used to test the initial framework / API setup

###App test page
curl -k -X GET https://phalcon.api.gousto/app/info -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456"

###get recipe 1
curl -k -X GET https://phalcon.api.gousto/recipe/1 -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456"

###rate recipe 1 with 3 stars
curl -k -X PUT https://phalcon.api.gousto/recipe/1/rate/3 -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456"

###create a new recipe (witll fail without POST data)
curl -k -X POST https://phalcon.api.gousto/recipe -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456"


For a deeper and more advanced api testing, please refer to the Postman test suite in this folder  [app/tests/api/]


##API testing with Postman

Using it for development & testing, I've built a Postman testsuite. I have dump it in [/tests/api/Gousto-restfulapi... .json]


##UnitTest with phpunit

You will find a small testsuite in [/tests/phpunit/] focused on testing parts of the Recipe controller & RecipeModel. Parts only due to the time I've already spent on this projects. 
This is purely to show 
1) that for me an app NEEDS unittesting, even for a coding test
2) that I have experience with unitesting
3) to show I know what is a UNIT-test, and that I am not testing a full API endpoint for example or a function relying on database data (functional testing) 

```
cd tests/phpunit; 
phpunit --testsuite gousto
NULL
PHPUnit 6.5.14 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.2.10-0ubuntu0.18.04.1
Configuration: /srv/www/phalconApi/tests/phpunit/phpunit.xml

......S...                                                        10 / 10 (100%)

Time: 1.27 seconds, Memory: 10.00MB

There was 1 skipped test:

1) Test\Phpunit\RecipeModelTest::testModelMetadataConsistency
Since I am not using a ful model metadata definition, I can't test the model attributes as I would normally do. See smaple code below

/srv/www/phalconApi/tests/phpunit/testsuites/models/RecipeModelTest.php:13

OK, but incomplete, skipped, or risky tests!
Tests: 10, Assertions: 14, Skipped: 1.
```



##Performance - benchmark:
 
To show this API is performant and stable, please refer to this Apache Benchmark result. This is running from my almost 4years old macbook, no caching other than php's zend opcache. 

Config:
  Ubuntu18 in vagrant/virtual box, sqlite3, nginx 1.14, php-fpm 7.2
 
 > **168 req/sec** 
 
 > **0 of 10K failed requests**

That seems very decent considering I'm using a dev laptop, a sqlite db & no caching mechanism. Up to 200+req/sec when hitting an endpoint that doesn't required db access.

Test output: 
 
``` 
$ab -k -c 20 -n 10000 -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456" https://phalcon.api.gousto/recipe/10
 This is ApacheBench, Version 2.3 <$Revision: 1807734 $>
 Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
 Licensed to The Apache Software Foundation, http://www.apache.org/
 
 Benchmarking phalcon.api.gousto (be patient)
 Completed 1000 requests
 Completed 2000 requests
 Completed 3000 requests
 Completed 4000 requests
 Completed 5000 requests
 Completed 6000 requests
 Completed 7000 requests
 Completed 8000 requests
 Completed 9000 requests
 Completed 10000 requests
 Finished 10000 requests
 
 
 Server Software:        nginx/1.14.0
 Server Hostname:        phalcon.api.gousto
 Server Port:            443
 SSL/TLS Protocol:       TLSv1.2,ECDHE-RSA-AES128-GCM-SHA256,2048,128
 TLS Server Name:        phalcon.api.gousto
 
 Document Path:          /recipe/10
 Document Length:        819 bytes
 
 Concurrency Level:      20
 Time taken for tests:   59.209 seconds
 Complete requests:      10000
 Failed requests:        0
 Keep-Alive requests:    0
 Total transferred:      9950000 bytes
 HTML transferred:       8190000 bytes
 Requests per second:    168.89 [#/sec] (mean)
 Time per request:       118.418 [ms] (mean)
 Time per request:       5.921 [ms] (mean, across all concurrent requests)
 Transfer rate:          164.11 [Kbytes/sec] received
 
 Connection Times (ms)
               min  mean[+/-sd] median   max
 Connect:        1    3   1.9      2      50
 Processing:    17  116  72.2    106    1344
 Waiting:       17  115  72.2    106    1344
 Total:         19  118  72.3    109    1346
 
 Percentage of the requests served within a certain time (ms)
   50%    109
   66%    117
   75%    122
   80%    126
   90%    137
   95%    150
   98%    220
   99%    295
  100%   1346 (longest request)
```

