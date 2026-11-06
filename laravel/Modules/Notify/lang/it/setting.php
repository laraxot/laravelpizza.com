<?php

declare(strict_types=1);

// SettingPage del modulo (BaseSettingPage, Xot). Tutte le chiavi che AutoLabelAction legge sono
// scritte qui: senza, il primo render le crea con valori grezzi.
return [
    'navigation' => [
        'label' => 'Impostazioni Notifiche',
        'group' => 'Notifiche',
        'icon' => 'heroicon-o-document-text',
        'sort' => 99,
    ],
    'title' => 'Impostazioni Notifiche',
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
    'fields' => [
        'cleanup_enabled' => [
            'label' => 'Pulizia automatica dei log',
        ],
        'cleanup_older_than_days' => [
            'label' => 'Elimina i log piu vecchi di (giorni)',
        ],
        'cleanup_batch_size' => [
            'label' => 'Dimensione del batch di eliminazione',
        ],
        'cleanup_keep_failed' => [
            'label' => 'Conserva i log degli invii falliti',
        ],
        'fcm_url' => [
            'label' => 'Endpoint FCM',
        ],
    ],
];
