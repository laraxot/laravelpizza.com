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
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'total_jobs' => [
            'label' => 'Emplois Totaux',
        ],
        'pending_jobs' => [
            'label' => 'Emplois en Attente',
        ],
        'failed_jobs' => [
            'label' => 'Emplois Échoués',
        ],
        'failed_job_ids' => [
            'label' => 'IDs des Emplois Échoués',
        ],
        'options' => [
            'label' => 'Options',
        ],
        'created_at' => [
            'label' => 'Créé À',
        ],
        'finished_at' => [
            'label' => 'Terminé À',
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
