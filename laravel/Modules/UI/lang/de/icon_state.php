<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Name eingeben',
            'help' => 'Identifizierender Name des Elements',
            'description' => 'Objektname',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'edit-name' => [
            'label' => 'Name bearbeiten',
            'placeholder' => 'Neuer Name',
            'help' => 'Den vorhandenen Namen ändern',
            'description' => 'Aktion zum Ändern des Namens',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'change-state' => [
            'label' => 'Status ändern',
            'placeholder' => 'Neuen Status auswählen',
            'help' => 'Den aktuellen Status ändern',
            'description' => 'Aktion zum Ändern des Status',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'state' => [
            'label' => 'Status',
            'placeholder' => 'Status auswählen',
            'help' => 'Aktueller Status des Elements',
            'description' => 'Aktueller Systemzustand',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'message' => [
            'label' => 'Nachricht',
            'placeholder' => 'Nachricht eingeben',
            'help' => 'Informative Nachricht',
            'description' => 'Nachrichtentext',
            'helper_text' => '',
            'tooltip' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Ungültige Statusinstanz',
        'record_not_found' => 'Datensatz nicht gefunden',
        'transition_completed' => [
            'title' => 'Übergang abgeschlossen',
            'body' => 'Statusübergang wurde erfolgreich abgeschlossen',
        ],
        'transition_error' => [
            'title' => 'Übergangsfehler',
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
