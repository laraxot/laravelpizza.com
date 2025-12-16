<?php

declare(strict_types=1);

return [
    'list_log_activities' => [
        'label' => 'Verlauf',
        'tooltip' => 'Änderungsverlauf anzeigen',
        'icon' => 'heroicon-o-clock',
        'color' => 'gray',
        'modal' => [
            'heading' => 'Änderungsverlauf',
            'description' => 'Alle Änderungen an diesem Datensatz anzeigen',
        ],
        'messages' => [
            'no_activities' => 'Keine Änderungen für diesen Datensatz aufgezeichnet',
            'loading' => 'Verlauf wird geladen...',
        ],
    ],
];
