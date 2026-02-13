<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Pianificazione',
        'group' => 'Strumenti',
        'icon' => 'heroicon-o-calendar',
        'sort' => 31,
    ],
    'label' => 'Pianificazione',
    'plural_label' => 'Pianificazioni',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'command' => [
            'label' => 'Comando',
        ],
        'expression' => [
            'label' => 'Espressione cron',
        ],
        'description' => [
            'label' => 'Descrizione',
        ],
        'timezone' => [
            'label' => 'Fuso orario',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
    ],
    'actions' => [
        'run' => [
            'label' => 'Esegui',
        ],
        'enable' => [
            'label' => 'Abilita',
        ],
        'disable' => [
            'label' => 'Disabilita',
        ],
    ],
];
