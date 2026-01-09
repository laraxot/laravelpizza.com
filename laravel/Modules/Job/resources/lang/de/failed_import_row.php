<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Fehlgeschlagene Importzeile',
        'group' => 'Fehlgeschlagene Importzeilen',
        'icon' => 'heroicon-o-exclamation-circle',
        'sort' => 28,
    ],
    'label' => 'Fehlgeschlagene Importzeile',
    'plural_label' => 'Fehlgeschlagene Importzeilen',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'import_batch_id' => [
            'label' => 'Import-Batch-ID',
        ],
        'row_index' => [
            'label' => 'Zeilenindex',
        ],
        'errors' => [
            'label' => 'Fehler',
        ],
        'data' => [
            'label' => 'Daten',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
    ],
    'actions' => [
        'view_errors' => [
            'label' => 'Fehler Anzeigen',
        ],
        'fix_row' => [
            'label' => 'Zeile Korrigieren',
        ],
    ],
];
