<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Authentification',
        'icon' => 'heroicon-o-shield-exclamation',
        'label' => 'Journaux d\'Authentification',
        'sort' => 5,
    ],
    'label' => 'Journal d\'Authentification',
    'plural_label' => 'Journaux d\'Authentification',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utilisateur',
        ],
        'ip_address' => [
            'label' => 'Adresse IP',
        ],
        'user_agent' => [
            'label' => 'User Agent',
        ],
        'login_at' => [
            'label' => 'Connexion le',
        ],
        'logout_at' => [
            'label' => 'Déconnexion le',
        ],
        'login_method' => [
            'label' => 'Méthode de connexion',
        ],
        'success' => [
            'label' => 'Succès',
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'tooltip' => 'Réorganiser les Enregistrements',
            'icon' => 'reorderRecords',
            'label' => 'Réorganiser les Enregistrements',
        ],
        'view_details' => [
            'label' => 'Voir les détails',
        ],
        'export_logs' => [
            'label' => 'Exporter les journaux',
        ],
    ],
];
