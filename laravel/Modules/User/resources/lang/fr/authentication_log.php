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
        ],
        'user_id' => [
            'label' => 'Utilisateur',
        ],
        'ip_address' => [
            'label' => 'Adresse IP',
        ],
        'user_agent' => [
            'label' => 'Agent Utilisateur',
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
