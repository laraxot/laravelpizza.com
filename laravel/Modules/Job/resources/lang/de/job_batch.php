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
        ],
        'name' => [
            'label' => 'Name',
        ],
        'total_jobs' => [
            'label' => 'Gesamte Aufträge',
        ],
        'pending_jobs' => [
            'label' => 'Ausstehende Aufträge',
        ],
        'failed_jobs' => [
            'label' => 'Fehlgeschlagene Aufträge',
        ],
        'failed_job_ids' => [
            'label' => 'IDs Fehlgeschlagener Aufträge',
        ],
        'options' => [
            'label' => 'Optionen',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
        'finished_at' => [
            'label' => 'Abgeschlossen Am',
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
