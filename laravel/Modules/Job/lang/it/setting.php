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
        'max_attempts' => [
            'label' => 'Tentativi per job',
            'placeholder' => '3',
            'helper_text' => 'Passato a queue:work --tries quando worker:check avvia il worker. Dopo l\'ultimo tentativo il job finisce tra i falliti.',
            'tooltip' => '',
            'description' => '',
        ],
        'timeout_seconds' => [
            'label' => 'Durata massima di un job (secondi)',
            'placeholder' => '60',
            'helper_text' => 'Passato a queue:work --timeout. Deve restare sotto il retry_after della connessione queue, altrimenti lo stesso job parte due volte.',
            'tooltip' => '',
            'description' => '',
        ],
        'sleep_seconds' => [
            'label' => 'Attesa a coda vuota (secondi)',
            'placeholder' => '5',
            'helper_text' => 'Passato a queue:work --sleep. Vale solo per un worker avviato da worker:check: uno già in esecuzione non cambia finché non viene riavviato.',
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
