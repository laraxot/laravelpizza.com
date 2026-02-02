<?php

declare(strict_types=1);

return [
    'limesurvey' => [
        'api' => [
            'url' => env('LIMESURVEY_URL', ''),
            'username' => env('LIMESURVEY_USERNAME', ''),
            'password' => env('LIMESURVEY_PASSWORD', ''),
        ],
    ],
];
