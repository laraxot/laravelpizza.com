<?php

declare(strict_types=1);

return [
    'default' => 'smsfactor',

    'drivers' => [
        'smsfactor' => [
            'token' => null,
            'base_url' => 'https://api.smsfactor.com',
        ],
    ],

    'debug' => false,
    'queue' => 'default',
    'retry' => [
        'attempts' => 3,
        'delay' => 60,
    ],
    'rate_limit' => [
        'enabled' => true,
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],
    'circuit_breaker' => [
        'enabled' => true,
        'threshold' => 5,
        'timeout' => 60,
    ],
    'timeout' => 30,
    'logging' => [
        'enabled' => true,
        'channel' => 'stack',
    ],
    'validation' => [
        'enabled' => true,
        'pattern' => '/^\+[1-9]\d{1,14}$/',
    ],
];
