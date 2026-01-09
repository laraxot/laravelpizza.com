<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Tâches en attente',
        'group' => 'Tâches',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Tâche en attente',
    'plural_label' => 'Tâches en attente',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'connection' => [
            'label' => 'Connexion',
        ],
        'queue' => [
            'label' => 'File d\'attente',
        ],
        'payload' => [
            'label' => 'Contenu',
        ],
        'attempts' => [
            'label' => 'Tentatives',
        ],
        'reserved_at' => [
            'label' => 'Réservé le',
        ],
        'available_at' => [
            'label' => 'Disponible le',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
    ],
    'actions' => [
        'process' => [
            'label' => 'Traiter',
        ],
        'retry' => [
            'label' => 'Réessayer',
        ],
    ],
];