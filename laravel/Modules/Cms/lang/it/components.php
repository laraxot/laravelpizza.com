<?php

declare(strict_types=1);

return [
    'alert' => [
        'title' => 'Avviso',
        'types' => [
            'info' => 'Informazione',
            'success' => 'Successo',
            'warning' => 'Attenzione',
            'error' => 'Errore',
        ],
        'actions' => [
            'dismiss' => 'Chiudi',
        ],
    ],
    'button' => [
        'types' => [
            'primary' => 'Primario',
            'secondary' => 'Secondario',
            'danger' => 'Pericolo',
            'warning' => 'Attenzione',
            'info' => 'Info',
            'success' => 'Successo',
        ],
        'sizes' => [
            'xs' => 'Extra piccolo',
            'sm' => 'Piccolo',
            'md' => 'Medio',
            'lg' => 'Grande',
            'xl' => 'Extra grande',
        ],
    ],
    'card' => [
        'actions' => [
            'expand' => 'Espandi',
            'collapse' => 'Comprimi',
            'close' => 'Chiudi',
        ],
    ],
    'modal' => [
        'actions' => [
            'close' => 'Chiudi',
            'confirm' => 'Conferma',
            'cancel' => 'Annulla',
        ],
    ],
    'form' => [
        'fields' => [
            'required' => 'Campo obbligatorio',
            'optional' => 'Opzionale',
        ],
        'validation' => [
            'required' => 'Questo campo è obbligatorio',
            'email' => 'Inserisci un indirizzo email valido',
            'min' => 'Inserisci almeno :min caratteri',
            'max' => 'Inserisci al massimo :max caratteri',
        ],
        'actions' => [
            'submit' => 'Invia',
            'reset' => 'Reimposta',
            'cancel' => 'Annulla',
        ],
    ],
    'table' => [
        'actions' => [
            'edit' => 'Modifica',
            'delete' => 'Elimina',
            'view' => 'Visualizza',
        ],
        'empty' => 'Nessun dato disponibile',
        'pagination' => [
            'previous' => 'Precedente',
            'next' => 'Successivo',
            'showing' => 'Visualizzazione',
            'to' => 'a',
            'of' => 'di',
            'results' => 'risultati',
        ],
    ],
    'tabs' => [
        'actions' => [
            'previous' => 'Precedente',
            'next' => 'Successivo',
        ],
    ],
    'loading' => [
        'text' => 'Caricamento in corso...',
    ],
    'error' => [
        'title' => 'Errore',
        'description' => 'Si è verificato un errore',
        'actions' => [
            'retry' => 'Riprova',
            'back' => 'Indietro',
        ],
    ],
];
