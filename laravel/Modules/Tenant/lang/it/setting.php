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
        'title' => [
            'label' => 'Nome del sito',
            'placeholder' => 'Il nome che compare nei pannelli',
            'helper_text' => 'Nome del brand: barra dei pannelli di amministrazione, titolo e nome del sito nel front office, dati strutturati.',
            'tooltip' => '',
            'description' => '',
        ],
        'logo_height' => [
            'label' => 'Altezza del logo',
            'placeholder' => '2em',
            'helper_text' => 'Altezza del logo nei pannelli di amministrazione: un numero con px, em o rem (es. 2em, 32px).',
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
