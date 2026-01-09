<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Fournisseur SSO',
        'group' => 'Authentification',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 41,
    ],
    'label' => 'Fournisseur SSO',
    'plural_label' => 'Fournisseurs SSO',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'provider' => [
            'label' => 'Fournisseur',
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
        'active' => [
            'label' => 'Actif',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
        'updated_at' => [
            'label' => 'Mis à jour le',
        ],
    ],
    'actions' => [
        'activate' => [
            'label' => 'Activer',
        ],
        'deactivate' => [
            'label' => 'Désactiver',
        ],
        'test_connection' => [
            'label' => 'Tester la connexion',
        ],
    ],
];
