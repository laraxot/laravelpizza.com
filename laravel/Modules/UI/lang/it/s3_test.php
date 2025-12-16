<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Test S3',
        'group' => 'UI',
        'icon' => 'heroicon-o-cloud',
        'sort' => 50,
    ],
    'fields' => [
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci email destinatario',
            'helper_text' => '',
            'description' => 'Indirizzo email del destinatario',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Inserisci oggetto email',
            'helper_text' => '',
            'description' => 'Oggetto dell\'email di test',
        ],
        'body_html' => [
            'label' => 'Corpo HTML',
            'placeholder' => 'Inserisci contenuto HTML',
            'helper_text' => '',
            'description' => 'Contenuto HTML dell\'email',
        ],
        'attachment' => [
            'description' => 'Allegato per il test S3',
            'helper_text' => '',
            'placeholder' => 'Seleziona file da allegare',
            'label' => 'Allegato',
        ],
        'debug_output' => [
            'description' => 'Output di debug per i test',
            'helper_text' => '',
            'placeholder' => 'Output debug',
            'label' => 'Debug Output',
        ],
    ],
    'actions' => [
        'emailFormActions' => [
            'label' => 'Azioni Email',
            'tooltip' => 'Azioni per la gestione email',
        ],
        'save' => [
            'label' => 'Salva',
            'tooltip' => 'Salva configurazione test',
        ],
        'formActions' => [
            'label' => 'Azioni Form',
            'tooltip' => 'Azioni per la gestione form',
        ],
        'sendEmail' => [
            'label' => 'Invia Email',
            'tooltip' => 'Invia email di test',
        ],
        'runAllTests' => [
            'label' => 'Esegui Tutti i Test',
            'tooltip' => 'Esegui tutti i test S3',
        ],
        'testCloudFront' => [
            'label' => 'Test CloudFront',
            'tooltip' => 'Testa connessione CloudFront',
        ],
        'testPermissions' => [
            'label' => 'Test Permessi',
            'tooltip' => 'Testa permessi S3',
        ],
        'testS3Connection' => [
            'label' => 'Test Connessione S3',
            'tooltip' => 'Testa connessione Amazon S3',
        ],
        'testCredentials' => [
            'label' => 'Test Credenziali',
            'tooltip' => 'Testa credenziali AWS',
        ],
        'clearResults' => [
            'label' => 'Pulisci Risultati',
            'tooltip' => 'Pulisci risultati test',
        ],
        'debugConfig' => [
            'label' => 'Debug Configurazione',
            'tooltip' => 'Debug configurazione S3',
        ],
        'testBucketPolicy' => [
            'label' => 'Test Policy Bucket',
            'tooltip' => 'Testa policy del bucket S3',
        ],
        'testFileOperations' => [
            'label' => 'Test Operazioni File',
            'tooltip' => 'Testa operazioni sui file S3',
        ],
    ],
];
