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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Contenu',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'File d\'attente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'attempts' => [
            'label' => 'Tentatives',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reserved_at' => [
            'label' => 'Réservé le',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'available_at' => [
            'label' => 'Disponible le',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Créé le',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
