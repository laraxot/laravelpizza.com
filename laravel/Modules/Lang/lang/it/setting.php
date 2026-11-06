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
        'default_locale' => [
            'label' => 'Lingua di apertura dell\'editor',
            'placeholder' => 'Come l\'applicazione',
            'helper_text' => 'Lingua con cui si apre l\'editor delle traduzioni. Se non è tra le lingue scelte, o è vuota, vale la lingua dell\'applicazione (app.locale).',
            'tooltip' => '',
            'description' => '',
        ],
        'supported_locales' => [
            'label' => 'Lingue dell\'editor delle traduzioni',
            'placeholder' => '',
            'helper_text' => 'Le lingue in cui si modificano i file di traduzione. Non cambia le lingue del sito, che dipendono da laravellocalization.',
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
