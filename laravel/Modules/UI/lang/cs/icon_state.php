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
        ],
        'edit-name' => [
            'label' => 'Upravit název',
            'placeholder' => 'Nový název',
            'help' => 'Upravit existující název',
            'description' => 'Akce pro úpravu názvu',
            'helper_text' => '',
        ],
        'change-state' => [
            'label' => 'Změnit stav',
            'placeholder' => 'Vybrat nový stav',
            'help' => 'Upravit aktuální stav',
            'description' => 'Akce pro změnu stavu',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'Stav',
            'placeholder' => 'Vybrat stav',
            'help' => 'Aktuální stav prvku',
            'description' => 'Aktuální systémová podmínka',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'Zpráva',
            'placeholder' => 'Zadejte zprávu',
            'help' => 'Informativní zpráva',
            'description' => 'Text zprávy',
            'helper_text' => '',
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
];
