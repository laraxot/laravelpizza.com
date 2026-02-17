<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lot d\'Emplois',
        'group' => 'Lots',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => 'Lot d\'Emplois',
    'plural_label' => 'Lots d\'Emplois',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nom',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'total_jobs' => [
            'label' => 'Emplois Totaux',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'pending_jobs' => [
            'label' => 'Emplois en Attente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_jobs' => [
            'label' => 'Emplois Échoués',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_job_ids' => [
            'label' => 'IDs des Emplois Échoués',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => 'Options',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Créé À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'finished_at' => [
            'label' => 'Terminé À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Voir les Détails',
        ],
        'cancel' => [
            'label' => 'Annuler',
        ],
        'prune_batches' => [
            'label' => 'Nettoyer les Lots',
        ],
    ],
];
