<?php

declare(strict_types=1);

return [
    'servizio_verifica_dich_generalita' => [
        'title' => 'Verifica Dichiarazioni Generalità',
        'description' => 'Pagina per la verifica delle dichiarazioni di generalità tramite i servizi ANPR.',
        'fields' => [
            'codiceFiscale' => [
                'label' => 'Codice Fiscale',
                'placeholder' => 'Inserisci Codice Fiscale',
                'help' => '',
            ],
            'cognome' => [
                'label' => 'Cognome',
                'placeholder' => 'Inserisci Cognome',
                'help' => '',
            ],
            'nome' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci Nome',
                'help' => '',
            ],
            'sesso' => [
                'label' => 'Sesso',
                'placeholder' => 'Inserisci Sesso',
                'help' => '',
            ],
            'dataNascita' => [
                'label' => 'Data di Nascita',
                'placeholder' => 'Inserisci Data di Nascita',
                'help' => '',
            ],
            'nomeComune' => [
                'label' => 'Comune di Nascita',
                'placeholder' => 'Inserisci Comune di Nascita',
                'help' => '',
            ],
            'codiceIstat' => [
                'label' => 'Codice ISTAT',
                'placeholder' => 'Inserisci Codice ISTAT del Comune',
                'help' => '',
            ],
            'siglaProvinciaIstat' => [
                'label' => 'Sigla Provincia ISTAT',
                'placeholder' => 'Inserisci Sigla Provincia',
                'help' => '',
            ],
            'descrizioneLocalita' => [
                'label' => 'Località di Nascita',
                'placeholder' => 'Inserisci Località di Nascita',
                'help' => '',
            ],
        ],
        'actions' => [
            'send' => 'Invia Richiesta', // Name of the action is 'send'
        ],
        'notifications' => [
            'search_completed' => 'Ricerca completata',
            'search_error' => 'Errore nella ricerca',
            'unexpected_error' => 'Errore imprevisto',
        ],
        'sections' => [
            // Potentially add sections here if the form had distinct sections
        ],
    ],
];
