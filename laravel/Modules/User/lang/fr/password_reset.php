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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'token' => [
            'label' => 'Jeton',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Créé À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
