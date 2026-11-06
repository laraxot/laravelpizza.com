<?php

declare(strict_types=1);

// SettingPage del modulo (BaseSettingPage, Xot). Tutte le chiavi che AutoLabelAction legge sono
// scritte qui: senza, il primo render le crea con valori grezzi.
return [
    'navigation' => [
        'label' => 'Impostazioni',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Impostazioni',
    'fields' => [
        'dark_mode_switcher_enabled' => [
            'label' => 'Mostra il selettore tema chiaro/scuro',
            'placeholder' => '',
            'helper_text' => 'Se spento, il selettore tema chiaro/scuro sparisce dal pannello e dai temi.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Salva',
        ],
        'profile' => [
            'label' => 'Profilo',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profilo',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Esci',
        ],
    ],
];
