<?php

return [
    'sdm' => [
        'secret' => env('SDM_SERVICE_SECRET'),
        'base_uri' => env('SDM_SERVICE_BASE_URL')
    ],

    'auth' => [
        'secret' => env('AUTH_SERVICE_SECRET'),
        'base_uri' => env('AUTH_SERVICE_BASE_URL')
    ],

    'log' => [
        'secret' => env('LOG_SERVICE_SECRET'),
        'base_uri' => env('LOG_SERVICE_BASE_URL')
    ],

    'temp' => [
        'base_uri' => env('TEMP_SERVICE_BASE_URL')
    ],

    'vclaim' => [
        'base_uri' => env('VCLAIM_BASE_URL'),
        'cons_id' => env('CONS_ID'),
        'cons_secret' => env('CONS_SECRET'),
        'user_key' => env('USER_KEY')
    ],
];
