<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Mappa Webbingbrasil',
        'group' => 'Gestione Territorio',
        'icon' => 'heroicon-o-map',
        'sort' => 60,
    ],
    'controls' => [
        'zoom' => [
            'in' => 'Aumenta zoom',
            'out' => 'Diminuisci zoom',
        ],
        'fullscreen' => 'Schermo intero',
        'layers' => 'Cambia layer',
    ],
    'markers' => [
        'add' => 'Aggiungi marker',
        'remove' => 'Rimuovi marker',
        'edit' => 'Modifica marker',
    ],
    'messages' => [
        'marker_added' => 'Marker aggiunto con successo',
        'marker_removed' => 'Marker rimosso con successo',
        'marker_updated' => 'Marker aggiornato con successo',
    ],
];
