<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Réinitialisation de mot de passe',
        'group' => 'Sécurité',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Réinitialisation de mot de passe',
    'plural_label' => 'Réinitialisations de mot de passe',
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
            'label' => 'Créé le',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'Renvoyer l\'email',
        ],
        'view_request' => [
            'label' => 'Voir la demande',
        ],
    ],
];
