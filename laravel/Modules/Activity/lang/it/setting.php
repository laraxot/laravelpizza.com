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
        'enabled' => [
            'label' => 'Registra le attività',
            'placeholder' => '',
            'helper_text' => 'Spento: nessuna attività viene più scritta nel registro. Salvandolo, vale al posto di ACTIVITY_LOGGER_ENABLED.',
            'tooltip' => '',
            'description' => '',
        ],
        'clean_after_days' => [
            'label' => 'Giorni di conservazione',
            'placeholder' => '365',
            'helper_text' => 'Usato da php artisan activitylog:clean, che cancella le attività più vecchie. Il comando non è pianificato: parte solo se qualcuno lo lancia.',
            'tooltip' => '',
            'description' => '',
        ],
        'default_log_name' => [
            'label' => 'Nome del registro predefinito',
            'placeholder' => 'default',
            'helper_text' => 'Nome usato quando activity() non ne indica uno. Cambiarlo separa le nuove attività da quelle già registrate.',
            'tooltip' => '',
            'description' => '',
        ],
        'include_soft_deleted_subjects' => [
            'label' => 'Mostra i soggetti cancellati',
            'placeholder' => '',
            'helper_text' => 'Acceso: il soggetto di un\'attività viene mostrato anche se il record è stato cancellato con soft delete.',
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
