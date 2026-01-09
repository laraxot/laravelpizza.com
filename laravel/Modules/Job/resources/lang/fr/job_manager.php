<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Gestionnaire de tâches',
        'group' => 'Tâches',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Gestionnaire de tâches',
    'plural_label' => 'Gestionnaires de tâches',
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
        'last_heartbeat' => [
            'label' => 'Dernier battement',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
        'updated_at' => [
            'label' => 'Mis à jour le',
        ],
    ],
    'actions' => [
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