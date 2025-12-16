<?php

declare(strict_types=1);

return [
    'list_log_activities' => [
        'label' => 'Cronologia',
        'tooltip' => 'Visualizza storico modifiche',
        'icon' => 'heroicon-o-clock',
        'color' => 'gray',
        'modal' => [
            'heading' => 'Storico Modifiche',
            'description' => 'Visualizza tutte le modifiche effettuate su questo record',
        ],
        'view_all' => 'Visualizza Tutto',
        'close' => 'Chiudi',
        'messages' => [
            'no_activities' => 'Nessuna modifica registrata per questo record',
            'loading' => 'Caricamento storico in corso...',
        ],
    ],
];
