## Authentication 

Given this API needs to be "production" ready, we do need an authentication mechanism! We need to ensure the "client" is authenticated before accessing any data.

That being said, I've been asked to not code any FE code, there are no mention of "users", nothing about securoity either in this test description... So I've decided to go for the simplest possible HTTP token-based auth.


### In a nutshell: 

We'll look for a static token in the request header as we would do for an oAuth2 authentication flow -- with a more complex middleware and a Auth server/credentials/scopes...

For this test, the token name and value wll be statically stored in the $config file/object. That could arguably be stored in .env, a constant... in my opinion it doesn't matter much
for such a basic auth implementation.


As a result, all the HTTP requests in my curl & Postman testsuite contains the same headers:

`-H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456" `


#App status page

here is a curl example of how to access the status page, using the define basic auth mechanism: 

```
curl -k -X GET https://phalcon.api.gousto/app/status -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456"
```