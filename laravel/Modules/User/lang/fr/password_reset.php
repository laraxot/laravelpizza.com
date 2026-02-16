<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Réinitialisation de Mot de Passe',
        'group' => 'Sécurité',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Réinitialisation de Mot de Passe',
    'plural_label' => 'Réinitialisations de Mot de Passe',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'token' => [
            'label' => 'Jeton',
        ],
        'created_at' => [
            'label' => 'Créé À',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'Renvoyer l\'Email',
        ],
        'view_request' => [
            'label' => 'Voir la Demande',
        ],
    ],
];
