<?php

return new \Phalcon\Config(
    [
        'sqlite' => [
            'adapter' => 'Sqlite',
            "dbname" => "/srv/www/phalconApi/db/gousto",
        ],

        'application' => [
	        'controllersDir' => "app/controllers/",
	        'modelsDir'      => "app/models/",
	        'baseUri'        => "/",
        ],
        
        'runtime' => [
                'debug' => true,
	        'display_errors' => true,
	        'log_errors' => false,
        ],
        'auth-token' => [
            'name' => 'gousto-auth-token',
            'value' => 'abcdef123456'
        ]
    ]
);
