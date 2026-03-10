<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Název',
            'placeholder' => 'Zadejte název',
            'help' => 'Identifikační název prvku',
            'description' => 'Název objektu',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'edit-name' => [
            'label' => 'Upravit název',
            'placeholder' => 'Nový název',
            'help' => 'Upravit existující název',
            'description' => 'Akce pro úpravu názvu',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'change-state' => [
            'label' => 'Změnit stav',
            'placeholder' => 'Vybrat nový stav',
            'help' => 'Upravit aktuální stav',
            'description' => 'Akce pro změnu stavu',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'state' => [
            'label' => 'Stav',
            'placeholder' => 'Vybrat stav',
            'help' => 'Aktuální stav prvku',
            'description' => 'Aktuální systémová podmínka',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'message' => [
            'label' => 'Zpráva',
            'placeholder' => 'Zadejte zprávu',
            'help' => 'Informativní zpráva',
            'description' => 'Text zprávy',
            'helper_text' => '',
            'tooltip' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Neplatná instance stavu',
        'record_not_found' => 'Záznam nenalezen',
        'transition_completed' => [
            'title' => 'Přechod dokončen',
            'body' => 'Přechod stavu byl úspěšně dokončen',
        ],
        'transition_error' => [
            'title' => 'Chyba přechodu',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
