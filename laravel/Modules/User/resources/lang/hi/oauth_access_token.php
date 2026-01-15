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
        ],
        'user_id' => [
            'label' => 'उपयोगकर्ता',
        ],
        'client_id' => [
            'label' => 'क्लाइंट',
        ],
        'name' => [
            'label' => 'नाम',
        ],
        'scopes' => [
            'label' => 'स्कोप',
        ],
        'revoked' => [
            'label' => 'रद्द किया गया',
        ],
        'expires_at' => [
            'label' => 'समाप्ति तिथि',
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
