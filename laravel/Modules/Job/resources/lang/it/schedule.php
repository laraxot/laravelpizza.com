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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'command' => [
            'label' => 'Comando',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expression' => [
            'label' => 'Espressione cron',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'timezone' => [
            'label' => 'Fuso orario',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
