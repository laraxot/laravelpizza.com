<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Créer',
        ],
        'logout' => [
            'tooltip' => 'Déconnexion',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'label' => 'Déconnexion',
        ],
        'cancel' => [
            'tooltip' => 'Annuler',
        ],
        'reorderRecords' => [
            'tooltip' => 'Réorganiser les enregistrements',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Modifier',
        ],
        'payload' => [
            'label' => 'Contenu',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'queue' => [
            'label' => 'File d\'attente',
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
    'navigation' => [
        'sort' => 58,
        'icon' => 'heroicon-o-cog',
        'group' => 'Tâches',
        'label' => 'Tâche',
    ],
    'label' => 'Tâche',
    'plural_label' => 'Tâches',
];
