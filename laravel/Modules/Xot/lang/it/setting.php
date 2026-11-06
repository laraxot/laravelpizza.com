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
        'main_module' => [
            'label' => 'Modulo principale',
            'placeholder' => 'Scegli un modulo',
            'helper_text' => 'Il suo pannello e\' quello predefinito. Solo i moduli abilitati che hanno un pannello.',
            'tooltip' => '',
            'description' => '',
        ],
        'primary_lang' => [
            'label' => 'Lingua primaria',
            'placeholder' => 'Scegli una lingua',
            'helper_text' => 'Lingua dei contenuti usata quando manca la traduzione nella lingua corrente.',
            'tooltip' => '',
            'description' => '',
        ],
        'force_ssl' => [
            'label' => 'Forza https',
            'placeholder' => '',
            'helper_text' => 'Genera gli URL con https. Ignorato in locale (localhost, 127.0.0.1).',
            'tooltip' => '',
            'description' => '',
        ],
        'disable_database_notifications' => [
            'label' => 'Nascondi le notifiche del pannello',
            'placeholder' => '',
            'helper_text' => 'Acceso: nessuna campanella nei pannelli. Spento: la campanella legge le notifiche dal database.',
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
