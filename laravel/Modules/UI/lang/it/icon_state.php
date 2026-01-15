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
        ],
        'edit-name' => [
            'label' => 'Modifica nome',
            'placeholder' => 'Nuovo nome',
            'help' => 'Modifica il nome esistente',
            'description' => 'Azione per modificare il nome',
            'helper_text' => '',
        ],
        'change-state' => [
            'label' => 'Cambia stato',
            'placeholder' => 'Seleziona il nuovo stato',
            'help' => 'Modifica lo stato corrente',
            'description' => 'Azione per cambiare lo stato',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona uno stato',
            'help' => 'Stato attuale dell\'elemento',
            'description' => 'Condizione corrente del sistema',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio',
            'help' => 'Messaggio informativo',
            'description' => 'Testo del messaggio',
            'helper_text' => '',
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
];
