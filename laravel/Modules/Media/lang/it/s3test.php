<?php

declare(strict_types=1);

return [
    'actions' => [
        'testCredentials' => [
            'label' => 'Test Credenziali AWS',
            'tooltip' => 'Verifica le credenziali AWS configurate',
        ],
        'testS3Connection' => [
            'label' => 'Test Connessione S3',
            'tooltip' => 'Verifica la connessione al bucket S3',
        ],
        'testPermissions' => [
            'label' => 'Test Permessi S3',
            'tooltip' => 'Verifica i permessi per operazioni S3',
        ],
        'testBucketPolicy' => [
            'label' => 'Test Policy Bucket',
            'tooltip' => 'Verifica la policy del bucket S3',
        ],
        'testCloudFront' => [
            'label' => 'Test CloudFront',
            'tooltip' => 'Verifica la configurazione CloudFront',
        ],
        'testFileOperations' => [
            'label' => 'Test Operazioni File',
            'tooltip' => 'Testa upload, download e cancellazione file',
        ],
        'debugConfig' => [
            'label' => 'Debug Configurazione',
            'tooltip' => 'Mostra la configurazione AWS corrente',
        ],
        'clearResults' => [
            'label' => 'Cancella Risultati',
            'tooltip' => 'Cancella tutti i risultati dei test',
        ],
        'sendEmail' => [
            'label' => 'Invia Email Test',
            'tooltip' => 'Invia email con allegato per test',
        ],
    ],
    'notifications' => [
        'credentials_tested' => 'Credenziali AWS testate',
        'bucket_policy_tested' => 'Policy bucket testata',
        'file_operations_tested' => 'Operazioni file testate',
        'config_debugged' => 'Configurazione analizzata',
        'results_cleared' => 'Risultati cancellati',
        's3_test_successful' => 'Test S3 completato con successo',
        'operations_completed' => 'Tutte le operazioni completate',
        'test_failed' => 'Test fallito',
        'no_attachment' => 'Nessun allegato selezionato',
        'upload_file_first' => 'Carica prima un file per testare',
        'email_sent' => 'Email test inviata',
        'email_with_attachment' => 'Email con allegato inviata correttamente',
        'email_failed' => 'Invio email fallito',
    ],
    'debug' => [
        'run_tests_message' => 'Esegui i test per vedere i risultati qui...',
    ],
    'fields' => [
        'attachment' => [
            'label' => 'Allegato',
            'placeholder' => 'Seleziona un file da allegare',
            'helper_text' => 'File di test per verificare le operazioni S3',
        ],
        'debug_output' => [
            'label' => 'Output Debug',
            'placeholder' => 'I risultati dei test appariranno qui',
            'helper_text' => 'Output dettagliato dei test eseguiti',
        ],
    ],
    'messages' => [
        'test_successful' => 'Test completato con successo',
        'test_failed' => 'Test fallito',
        'configuration_valid' => 'Configurazione valida',
        'configuration_invalid' => 'Configurazione non valida',
        'permissions_ok' => 'Permessi verificati',
        'permissions_failed' => 'Permessi insufficienti',
        'connection_ok' => 'Connessione stabilita',
        'connection_failed' => 'Connessione fallita',
    ],
    'errors' => [
        'aws_credentials_invalid' => 'Credenziali AWS non valide',
        's3_bucket_inaccessible' => 'Bucket S3 non accessibile',
        'cloudfront_config_incomplete' => 'Configurazione CloudFront incompleta',
        'file_operations_failed' => 'Operazioni file fallite',
        'permissions_insufficient' => 'Permessi insufficienti',
        'unknown_error' => 'Errore sconosciuto',
    ],
    'solutions' => [
        'check_credentials' => 'Verifica le credenziali AWS in .env',
        'check_bucket_name' => 'Verifica il nome del bucket S3',
        'check_region' => 'Verifica la regione AWS configurata',
        'check_permissions' => 'Verifica i permessi IAM per S3',
        'check_cloudfront_config' => 'Verifica la configurazione CloudFront',
        'contact_admin' => 'Contatta l\'amministratore del sistema',
    ],
];
