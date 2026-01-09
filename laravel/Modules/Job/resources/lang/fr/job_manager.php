<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Créer',
        ],
    ],
    'fields' => [
        'status' => [
            'label' => 'Statut',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'queue' => [
            'label' => 'File d\'attente',
        ],
        'progress' => [
            'label' => 'Progrès',
        ],
        'started_at' => [
            'label' => 'Démarré À',
        ],
    ],
    'navigation' => [
        'sort' => 87,
        'icon' => 'heroicon-o-cog-6-tooth',
        'group' => 'Système',
        'label' => 'Gestionnaire d\'Emplois',
    ],
];
