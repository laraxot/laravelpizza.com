<?php

declare(strict_types=1);

return [
    'default' => 'twilio',

    'drivers' => [
        'twilio' => [
            'account_sid' => null,
            'auth_token' => null,
            'from' => null,
        ],
        'vonage' => [
            'api_key' => null,
            'api_secret' => null,
            'from' => null,
        ],
        'facebook' => [
            'app_id' => null,
            'app_secret' => null,
            'access_token' => null,
            'phone_number_id' => null,
        ],
        '360dialog' => [
            'api_key' => null,
            'phone_number_id' => null,
        ],
    ],

    'debug' => false,
    'queue' => 'default',
    'timeout' => 30,
    'from' => null,
    'retry' => [
        'attempts' => 3,
        'delay' => 60,
    ],
    'rate_limit' => [
        'enabled' => true,
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],
];
