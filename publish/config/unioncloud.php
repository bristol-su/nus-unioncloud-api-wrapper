<?php

return [

    'baseURL' => env('UNIONCLOUD_BASEURL', 'unioncloud.org'),

    'authenticator' => env('AUTHENTICATOR', 'v0'),
    
    'v0auth' => [
        'email' => env('UNIONCLOUD_V0AUTH_EMAIL', 'email'),
        'password' => env('UNIONCLOUD_V0AUTH_PASSWORD', 'passsword'),
        'appID' => env('UNIONCLOUD_V0AUTH_APPID', 'appid'),
        'appPassword' => env('UNIONCLOUD_V0AUTH_APPPASSWORD', 'apppassword')
    ],
    
    'v1auth' => [
        'accessKey' => env('UNIONCLOUD_V1_ACCESS_KEY'),
        'secretKey' => env('UNIONCLOUD_V1_SECRET_KEY'),
        'apiKey' => env('UNIONCLOUD_V1_API_KEY')
    ]

];