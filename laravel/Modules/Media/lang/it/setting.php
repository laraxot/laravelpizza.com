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
        'attachment_max_size_kb' => [
            'label' => 'Dimensione massima allegati (KB)',
            'placeholder' => '10240',
            'helper_text' => 'Limite per ogni allegato caricato dalle schede delle Resource.',
            'tooltip' => '',
            'description' => '',
        ],
        'attachment_mime_types' => [
            'label' => 'Tipi di file ammessi',
            'placeholder' => 'application/pdf',
            'helper_text' => 'Tipi MIME accettati per gli allegati (es. application/pdf).',
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
