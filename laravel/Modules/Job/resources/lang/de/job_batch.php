<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Auftragsgruppe',
        'group' => 'Gruppen',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => 'Auftragsgruppe',
    'plural_label' => 'Auftragsgruppen',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'total_jobs' => [
            'label' => 'Gesamte Aufträge',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'pending_jobs' => [
            'label' => 'Ausstehende Aufträge',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_jobs' => [
            'label' => 'Fehlgeschlagene Aufträge',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_job_ids' => [
            'label' => 'IDs Fehlgeschlagener Aufträge',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => 'Optionen',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'finished_at' => [
            'label' => 'Abgeschlossen Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Details Anzeigen',
        ],
        'cancel' => [
            'label' => 'Abbrechen',
        ],
        'prune_batches' => [
            'label' => 'Batches Bereinigen',
        ],
    ],
];
