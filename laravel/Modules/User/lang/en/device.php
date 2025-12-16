<?php

declare(strict_types=1);

return [
    'fields' => [
        'uuid' => [
            'label' => 'UUID',
            'placeholder' => 'Enter device UUID',
            'help' => 'Unique device identifier',
        ],
        'mobile_id' => [
            'label' => 'Mobile ID',
            'placeholder' => 'Enter mobile ID',
            'help' => 'Mobile device identifier',
        ],
        'languages' => [
            'label' => 'Languages',
            'placeholder' => 'Add a language',
            'help' => 'Select or type language codes (e.g. it, en, es)',
        ],
        'device' => [
            'label' => 'Device Name',
            'placeholder' => 'Enter device name',
            'help' => 'Device name',
        ],
        'platform' => [
            'label' => 'Platform',
            'placeholder' => 'Enter platform',
            'help' => 'Device platform',
        ],
        'browser' => [
            'label' => 'Browser',
            'placeholder' => 'Enter browser',
            'help' => 'Browser used',
        ],
        'version' => [
            'label' => 'Version',
            'placeholder' => 'Enter version',
            'help' => 'Browser or system version',
        ],
        'is_robot' => [
            'label' => 'Is Robot',
            'placeholder' => 'Select if it is a robot',
            'help' => 'Indicates if the device is a robot',
        ],
        'robot' => [
            'label' => 'Robot',
            'placeholder' => 'Enter robot type',
            'help' => 'Robot type if applicable',
        ],
        'is_desktop' => [
            'label' => 'Is Desktop',
            'placeholder' => 'Select if it is desktop',
            'help' => 'Indicates if it is a desktop device',
        ],
        'is_mobile' => [
            'label' => 'Is Mobile',
            'placeholder' => 'Select if it is mobile',
            'help' => 'Indicates if it is a mobile device',
        ],
        'is_tablet' => [
            'label' => 'Is Tablet',
            'placeholder' => 'Select if it is tablet',
            'help' => 'Indicates if it is a tablet',
        ],
        'is_phone' => [
            'label' => 'Is Phone',
            'placeholder' => 'Select if it is phone',
            'help' => 'Indicates if it is a phone',
        ],
    ],
];
