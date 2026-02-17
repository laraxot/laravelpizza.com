<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth एक्सेस टोकन',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'OAuth एक्सेस टोकन',
    'plural_label' => 'OAuth एक्सेस टोकन',
    'fields' => [
        'id' => [
            'label' => 'आईडी',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_id' => [
            'label' => 'उपयोगकर्ता',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'client_id' => [
            'label' => 'क्लाइंट',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'नाम',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'scopes' => [
            'label' => 'स्कोप',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'revoked' => [
            'label' => 'रद्द किया गया',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expires_at' => [
            'label' => 'समाप्ति तिथि',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'रद्द करें',
        ],
        'refresh' => [
            'label' => 'ताज़ा करें',
        ],
    ],
];
