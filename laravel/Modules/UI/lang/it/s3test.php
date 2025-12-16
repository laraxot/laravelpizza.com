<?php

declare(strict_types=1);

return [
    'page' => [
        'title' => 'Test S3 e CloudFront',
        'heading' => 'Test Configurazione AWS',
        'description' => 'Pagina per testare la configurazione di S3 e CloudFront',
    ],
    'fields' => [
        'attachment' => [
            'label' => 'File di Test',
            'placeholder' => 'Carica un file per testare S3',
            'helper_text' => 'Il file verrà caricato su S3 per testare la configurazione',
        ],
        'debug_output' => [
            'label' => 'Risultati Debug',
            'placeholder' => 'I risultati dei test appariranno qui',
            'helper_text' => 'Output dettagliato dei test di configurazione AWS',
        ],
    ],
    'actions' => [
        'testCredentials' => [
            'label' => '🔐 Test Credenziali',
            'tooltip' => 'Testa le credenziali AWS utilizzando STS',
            'success' => 'Credenziali AWS testate con successo',
            'error' => 'Errore nel test delle credenziali AWS',
        ],
        'testS3Connection' => [
            'label' => '🔍 Test Connessione S3',
            'tooltip' => 'Testa la connessione al bucket S3',
            'success' => 'Connessione S3 testata con successo',
            'error' => 'Errore nel test della connessione S3',
        ],
        'testPermissions' => [
            'label' => '🔒 Test Permessi',
            'tooltip' => 'Testa i permessi S3 (ListBucket, PutObject, GetObject, DeleteObject)',
            'success' => 'Permessi S3 testati con successo',
            'error' => 'Errore nel test dei permessi S3',
        ],
        'testBucketPolicy' => [
            'label' => '📜 Test Policy Bucket',
            'tooltip' => 'Verifica la policy del bucket S3',
            'success' => 'Policy bucket verificata con successo',
            'error' => 'Errore nella verifica della policy bucket',
        ],
        'testCloudFront' => [
            'label' => '☁️ Test CloudFront',
            'tooltip' => 'Testa la configurazione CloudFront e generazione URL firmati',
            'success' => 'CloudFront testato con successo',
            'error' => 'Errore nel test di CloudFront',
        ],
        'testFileOperations' => [
            'label' => '📁 Test Operazioni File',
            'tooltip' => 'Testa le operazioni di upload e download file',
            'success' => 'Operazioni file testate con successo',
            'error' => 'Errore nel test delle operazioni file',
        ],
        'debugConfig' => [
            'label' => '📋 Debug Configurazione',
            'tooltip' => 'Mostra la configurazione AWS attuale',
            'success' => 'Configurazione debuggata con successo',
            'error' => 'Errore nel debug della configurazione',
        ],
        'clearResults' => [
            'label' => '🧹 Cancella Risultati',
            'tooltip' => 'Cancella tutti i risultati dei test',
            'success' => 'Risultati cancellati con successo',
            'error' => 'Errore nella cancellazione dei risultati',
        ],
        'sendEmail' => [
            'label' => '📧 Invia Email',
            'tooltip' => 'Testa l\'invio email con allegato S3',
            'success' => 'Email inviata con successo',
            'error' => 'Errore nell\'invio dell\'email',
        ],
    ],
    'notifications' => [
        's3_connection_tested' => 'Connessione S3 Testata',
        's3_permissions_tested' => 'Permessi S3 Testati',
        'cloudfront_tested' => 'CloudFront Testato',
        'credentials_tested' => 'Credenziali AWS Testate',
        'bucket_policy_tested' => 'Policy Bucket Testata',
        'file_operations_tested' => 'Operazioni File Testate',
        'config_debugged' => 'Configurazione Debuggata',
        'results_cleared' => 'Risultati Cancellati',
        'all_tests_completed' => 'Tutti i Test Completati',
        'email_sent_successfully' => 'Email Inviata con Successo',
        'email_send_failed' => 'Invio Email Fallito',
        'email_with_attachment' => 'Email di test inviata con allegato S3',
        'no_attachment' => '⚠️ Nessun allegato selezionato',
        'upload_file_first' => 'Carica prima un file per testare l\'invio email',
    ],
    'debug' => [
        'run_tests_message' => 'Esegui i test per vedere i risultati...',
        'configuration_title' => '📋 Configurazione',
        'credentials_title' => '🔐 Credenziali AWS',
        's3_connection_title' => '☁️ Connessione S3',
        'permissions_title' => '🔒 Permessi S3',
        'bucket_policy_title' => '📜 Policy Bucket',
        'cloudfront_title' => '☁️ CloudFront',
        'status_success' => 'successo',
        'status_error' => 'errore',
        'status_info' => 'info',
        'present' => '✅ Presente',
        'missing' => '❌ Mancante',
        'yes' => '✅ Sì',
        'no' => '❌ No',
        'ok' => '✅ OK',
        'complete' => '✅ Completo',
        'incomplete' => '❌ Incompleto',
    ],
    'email' => [
        'subject' => 'Test Email con Allegato S3',
        'body' => 'Questa è una email di test inviata dal sistema S3Test con allegato caricato su S3 e servito tramite CloudFront.',
    ],
];
