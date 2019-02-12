#!/usr/bin/env bash

clear;
echo "  -  -  -  -  -  -  -  -  -  -  -  -  ";
echo "Demoing the API functionalities";
echo "";
echo "";
sleep 2;

echo "  -  -  -  -  -  -  -  -  -  -  -  -  ";
echo "Root folder:";
echo "";
echo " ls -lh";
ls -lh;
sleep 3;


echo "  -  -  -  -  -  -  -  -  -  -  -  -  ";
echo "Unittest:";
echo "cd ./tests/phpunit/;";
echo "phpunit --testsuite=gousto";
sleep 3;

cd ./tests/phpunit/;
phpunit --testsuite=gousto;


echo "  -  -  -  -  -  -  -  -  -  -  -  -  ";
echo "Testing API with curl (2 examples):";
echo "";
cd ../..;
sleep 3;

echo '  >>> curl -k -X GET https://phalcon.api.gousto/recipe/1 -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456" ';
echo ""
curl -k -X GET https://phalcon.api.gousto/recipe/1 -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456"
sleep 2;
echo ""
echo " - - - "


echo '  >>> curl -k -X PUT https://phalcon.api.gousto/recipe/1/rate/3 -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456" ';
echo ""
curl -k -X PUT https://phalcon.api.gousto/recipe/1/rate/3 -H "Accept: application/json"  -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456"

echo "  -  -  -  -  -  -  -  -  -  -  -  -  ";
echo "Perforance benchmark";
echo "";
sleep 2;
echo '  >>>   ab -k -c 25 -n 2000 -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456" https://phalcon.api.gousto/recipe/10" ';

ab -k -c 25 -n 2000 -H "Content-Type: application/json" -H "gousto-auth-token: abcdef123456" https://phalcon.api.gousto/recipe/10;


sleep 2;
echo "";
echo "  -  -  -  -  -  -  -  -  -  -  -  -  ";
echo "To wrap up, Postman test suite: ";
echo "";
echo "";
sleep 5;

echo "Thank you for watching ! ";

