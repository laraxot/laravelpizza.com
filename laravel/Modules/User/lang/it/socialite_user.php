<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Utente Socialite',
        'group' => 'Autenticazione',
        'icon' => 'heroicon-o-user-group',
        'sort' => 40,
    ],
    'label' => 'Utente Socialite',
    'plural_label' => 'Utenti Socialite',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utente',
        ],
        'provider' => [
            'label' => 'Provider',
        ],
        'provider_id' => [
            'label' => 'ID Provider',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'avatar' => [
            'label' => 'Avatar',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'refresh_token' => [
            'label' => 'Token di aggiornamento',
        ],
        'expires_at' => [
            'label' => 'Scade il',
        ],
    ],
    'actions' => [
        'link_provider' => [
            'label' => 'Collega provider',
        ],
        'unlink_provider' => [
            'label' => 'Scollega provider',
        ],
    ],
];