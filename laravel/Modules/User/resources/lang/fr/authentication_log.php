<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Journaux d\'Authentification',
        'group' => 'Sécurité',
        'icon' => 'heroicon-o-lock-closed',
        'sort' => 36,
    ],
    'label' => 'Journal d\'Authentification',
    'plural_label' => 'Journaux d\'Authentification',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_id' => [
            'label' => 'Utilisateur',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'ip_address' => [
            'label' => 'Adresse IP',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_agent' => [
            'label' => 'Agent Utilisateur',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'label' => 'Connexion le',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'logout_at' => [
            'label' => 'Déconnexion le',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_method' => [
            'label' => 'Méthode de connexion',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'success' => [
            'label' => 'Succès',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Voir les détails',
        ],
        'export_logs' => [
            'label' => 'Exporter les journaux',
        ],
        'reorderRecords' => [
            'tooltip' => 'Réorganiser les enregistrements',
        ],
    ],
];
