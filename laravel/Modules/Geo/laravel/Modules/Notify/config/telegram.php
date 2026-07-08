<?php

declare(strict_types=1);

return [
    'default' => 'official',

    'drivers' => [
        'official' => [
            'token' => null,
            'api_url' => 'https://api.telegram.org',
        ],
        'botman' => [
            'token' => null,
            'api_url' => 'https://api.telegram.org',
            'webhook_url' => null,
        ],
        'nutgram' => [
            'token' => null,
            'api_url' => 'https://api.telegram.org',
            'webhook_url' => null,
            'polling' => false,
        ],
    ],

    'debug' => false,
    'queue' => 'default',
    'timeout' => 30,
    'parse_mode' => 'HTML',
    'retry' => [
        'attempts' => 3,
        'delay' => 60,
    ],
    'rate_limit' => [
        'enabled' => true,
        'max_attempts' => 30,
        'decay_minutes' => 1,
    ],
];
