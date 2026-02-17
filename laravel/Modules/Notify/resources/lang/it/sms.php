<?php

declare(strict_types=1);

return [
    'fields' => [
        'recipient' => [
            'label' => 'Destinatario',
            'helper_text' => 'Inserisci il numero di telefono nel formato internazionale (es. +393401234567).',
            'tooltip' => '',
            'description' => '',
        ],
        'to' => [
            'label' => 'Destinatario',
            'helper_text' => 'Inserisci il numero di telefono nel formato internazionale (es. +393401234567).',
            'tooltip' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Messaggio',
            'helper_text' => 'Inserisci il contenuto del messaggio (max 160 caratteri per un singolo SMS).',
            'tooltip' => '',
            'description' => '',
        ],
        'driver' => [
            'label' => 'Driver SMS',
            'helper_text' => 'Seleziona il provider per l\'invio dell\'SMS.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'send' => 'Invia SMS',
    ],
    'notifications' => [
        'sent' => [
            'title' => 'SMS Inviato',
            'body' => 'Il messaggio è stato preso in carico dal provider.',
        ],
        'error' => [
            'title' => 'Errore Invio',
            'body' => 'Si è verificato un errore durante l\'invio dell\'SMS.',
        ],
    ],
    'form' => [
        'to' => [
            'label' => 'Destinatario',
            'helper' => 'Numero di telefono con prefisso internazionale.',
        ],
        'from' => [
            'label' => 'Mittente',
            'helper' => 'Nome o numero del mittente (max 11 caratteri).',
        ],
        'body' => [
            'label' => 'Testo del Messaggio',
            'helper' => 'Contenuto dell\'SMS da inviare.',
        ],
        'provider' => [
            'label' => 'Provider',
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
];
