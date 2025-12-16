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
            'required' => 'Pflichtfeld',
            'optional' => 'Optional',
        ],
        'validation' => [
            'required' => 'Dieses Feld ist erforderlich',
            'email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein',
            'min' => 'Bitte geben Sie mindestens :min Zeichen ein',
            'max' => 'Bitte geben Sie höchstens :max Zeichen ein',
        ],
        'actions' => [
            'submit' => 'Senden',
            'reset' => 'Zurücksetzen',
            'cancel' => 'Abbrechen',
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
