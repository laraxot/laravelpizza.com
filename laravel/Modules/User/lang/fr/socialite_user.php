<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Utilisateur Socialite',
        'group' => 'Authentification',
        'icon' => 'heroicon-o-user-group',
        'sort' => 40,
    ],
    'label' => 'Utilisateur Socialite',
    'plural_label' => 'Utilisateurs Socialite',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utilisateur',
        ],
        'provider' => [
            'label' => 'Fournisseur',
        ],
        'provider_id' => [
            'label' => 'ID du fournisseur',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'avatar' => [
            'label' => 'Avatar',
        ],
        'token' => [
            'label' => 'Jeton',
        ],
        'refresh_token' => [
            'label' => 'Jeton d\'actualisation',
        ],
        'expires_at' => [
            'label' => 'Expire le',
        ],
    ],
    'actions' => [
        'link_provider' => [
            'label' => 'Lier le fournisseur',
        ],
        'unlink_provider' => [
            'label' => 'Dissocier le fournisseur',
        ],
    ],
];
