<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo dell\'elemento',
            'description' => 'Nome dell\'oggetto',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'edit-name' => [
            'label' => 'Modifica nome',
            'placeholder' => 'Nuovo nome',
            'help' => 'Modifica il nome esistente',
            'description' => 'Azione per modificare il nome',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'change-state' => [
            'label' => 'Cambia stato',
            'placeholder' => 'Seleziona il nuovo stato',
            'help' => 'Modifica lo stato corrente',
            'description' => 'Azione per cambiare lo stato',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'state' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona uno stato',
            'help' => 'Stato attuale dell\'elemento',
            'description' => 'Condizione corrente del sistema',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio',
            'help' => 'Messaggio informativo',
            'description' => 'Testo del messaggio',
            'helper_text' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'change-state' => [
            'label' => 'change-state',
            'icon' => 'change-state',
            'tooltip' => 'change-state',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Istanza di stato non valida',
        'record_not_found' => 'Record non trovato',
        'transition_completed' => [
            'title' => 'Transizione completata',
            'body' => 'La transizione di stato è stata completata con successo',
        ],
        'transition_error' => [
            'title' => 'Errore durante la transizione',
        ],
    ],
    'label' => 'Icon State',
    'plural_label' => 'Icon State (Plurale)',
    'navigation' => [
        'name' => 'Icon State',
        'plural' => 'Icon State',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Icon State',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
];
