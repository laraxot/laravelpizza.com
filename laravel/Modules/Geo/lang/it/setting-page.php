<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Impostazioni',
        'group' => 'Gestione Territorio',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'fields' => [
        'google_maps_api_key' => [
            'label' => 'Google Maps API Key',
            'helper' => 'Chiave API per l\'integrazione con Google Maps',
        ],
        'debugbar_enabled' => [
            'label' => 'Debug Bar',
            'helper' => 'Abilita/Disabilita la barra di debug',
        ],
    ],
    'actions' => [
        'save' => 'Salva Impostazioni',
        'reset' => 'Ripristina Predefiniti',
    ],
    'messages' => [
        'saved' => 'Impostazioni salvate con successo',
        'error' => 'Errore durante il salvataggio delle impostazioni',
    ],
];
