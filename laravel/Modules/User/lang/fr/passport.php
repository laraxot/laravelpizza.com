<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport',
        'group' => 'Sécurité',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 35,
    ],
    'label' => 'Passport',
    'plural_label' => 'Passport',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'client_id' => [
            'label' => 'ID Client',
        ],
        'client_secret' => [
            'label' => 'Clé secrète client',
        ],
        'redirect' => [
            'label' => 'Redirection',
        ],
        'personal_access_client' => [
            'label' => 'Client d\'accès personnel',
        ],
        'password_client' => [
            'label' => 'Client de mot de passe',
        ],
        'revoked' => [
            'label' => 'Révoqué',
        ],
    ],
    'actions' => [
        'create_client' => [
            'label' => 'Créer un client',
        ],
        'revoke' => [
            'label' => 'Révoquer',
        ],
    ],
];