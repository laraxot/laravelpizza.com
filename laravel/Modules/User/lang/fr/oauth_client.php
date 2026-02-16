<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Client OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 46,
    ],
    'label' => 'Client OAuth',
    'plural_label' => 'Clients OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utilisateur',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'secret' => [
            'label' => 'Secret',
        ],
        'provider' => [
            'label' => 'Fournisseur',
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
        'created_at' => [
            'label' => 'Créé le',
        ],
        'updated_at' => [
            'label' => 'Mis à jour le',
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
