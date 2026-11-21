<?php

declare(strict_types=1);

return [
    'sections' => [
        'Authentication Information' => [
            'label' => 'Authentication Information',
            'heading' => 'Authentication Information',
        ],
    ],
    'fields' => [
        'authenticatable_type' => [
            'label' => 'authenticatable_type',
            'placeholder' => 'authenticatable_type',
            'helper_text' => 'authenticatable_type',
            'description' => 'authenticatable_type',
        ],
        'authenticatable_id' => [
            'label' => 'authenticatable_id',
            'placeholder' => 'authenticatable_id',
            'helper_text' => 'authenticatable_id',
            'description' => 'authenticatable_id',
        ],
        'ip_address' => [
            'label' => 'Indirizzo IP',
            'placeholder' => 'ip_address',
            'helper_text' => 'ip_address',
            'description' => 'ip_address',
        ],
        'user_agent' => [
            'label' => 'Browser (user agent)',
            'placeholder' => 'user_agent',
            'helper_text' => 'user_agent',
            'description' => 'user_agent',
        ],
        'login_successful' => [
            'label' => 'Accesso riuscito',
            'placeholder' => 'login_successful',
            'helper_text' => 'login_successful',
            'description' => 'login_successful',
        ],
        'login_at' => [
            'label' => 'Accesso il',
            'placeholder' => 'login_at',
            'helper_text' => 'login_at',
            'description' => 'login_at',
        ],
        'logout_at' => [
            'label' => 'Uscita il',
            'placeholder' => 'logout_at',
            'helper_text' => 'logout_at',
            'description' => 'logout_at',
        ],
        'cleared_by_user' => [
            'label' => 'cleared_by_user',
            'placeholder' => 'cleared_by_user',
            'helper_text' => 'cleared_by_user',
            'description' => 'cleared_by_user',
        ],
    ],
];
