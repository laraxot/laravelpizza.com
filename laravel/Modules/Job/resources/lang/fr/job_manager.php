<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Gestionnaire d\'Emplois',
        'group' => 'Emplois',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Gestionnaire d\'Emplois',
    'plural_label' => 'Gestionnaires d\'Emplois',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'queue' => [
            'label' => 'File d\'attente',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'progress' => [
            'label' => 'Progrès',
        ],
        'started_at' => [
            'label' => 'Démarré À',
        ],
        'last_heartbeat' => [
            'label' => 'Dernier Battement',
        ],
        'created_at' => [
            'label' => 'Créé À',
        ],
        'updated_at' => [
            'label' => 'Mis À Jour À',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Créer',
        ],
        'restart' => [
            'label' => 'Redémarrer',
        ],
        'pause' => [
            'label' => 'Pause',
        ],
        'resume' => [
            'label' => 'Reprendre',
        ],
    ],
];
