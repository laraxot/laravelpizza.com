<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'testCredentials' => 
    array (
      'label' => 'Test Credenziali AWS',
      'tooltip' => 'Verifica le credenziali AWS configurate',
    ),
    'testS3Connection' => 
    array (
      'label' => 'Test Connessione S3',
      'tooltip' => 'Verifica la connessione al bucket S3',
    ),
    'testPermissions' => 
    array (
      'label' => 'Test Permessi S3',
      'tooltip' => 'Verifica i permessi per operazioni S3',
    ),
    'testBucketPolicy' => 
    array (
      'label' => 'Test Policy Bucket',
      'tooltip' => 'Verifica la policy del bucket S3',
    ),
    'testCloudFront' => 
    array (
      'label' => 'Test CloudFront',
      'tooltip' => 'Verifica la configurazione CloudFront',
    ),
    'testFileOperations' => 
    array (
      'label' => 'Test Operazioni File',
      'tooltip' => 'Testa upload, download e cancellazione file',
    ),
    'debugConfig' => 
    array (
      'label' => 'Debug Configurazione',
      'tooltip' => 'Mostra la configurazione AWS corrente',
    ),
    'clearResults' => 
    array (
      'label' => 'Cancella Risultati',
      'tooltip' => 'Cancella tutti i risultati dei test',
    ),
    'sendEmail' => 
    array (
      'label' => 'Invia Email Test',
      'tooltip' => 'Invia email con allegato per test',
    ),
  ),
  'notifications' => 
  array (
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
  ),
  'debug' => 
  array (
    'run_tests_message' => 'Esegui i test per vedere i risultati qui...',
  ),
  'fields' => 
  array (
    'attachment' => 
    array (
      'label' => 'Allegato',
      'placeholder' => 'Seleziona un file da allegare',
      'helper_text' => 'File di test per verificare le operazioni S3',
      'tooltip' => '',
      'description' => '',
    ),
    'debug_output' => 
    array (
      'label' => 'Output Debug',
      'placeholder' => 'I risultati dei test appariranno qui',
      'helper_text' => 'Output dettagliato dei test eseguiti',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'messages' => 
  array (
    'test_successful' => 'Test completato con successo',
    'test_failed' => 'Test fallito',
    'configuration_valid' => 'Configurazione valida',
    'configuration_invalid' => 'Configurazione non valida',
    'permissions_ok' => 'Permessi verificati',
    'permissions_failed' => 'Permessi insufficienti',
    'connection_ok' => 'Connessione stabilita',
    'connection_failed' => 'Connessione fallita',
  ),
  'errors' => 
  array (
    'aws_credentials_invalid' => 'Credenziali AWS non valide',
    's3_bucket_inaccessible' => 'Bucket S3 non accessibile',
    'cloudfront_config_incomplete' => 'Configurazione CloudFront incompleta',
    'file_operations_failed' => 'Operazioni file fallite',
    'permissions_insufficient' => 'Permessi insufficienti',
    'unknown_error' => 'Errore sconosciuto',
  ),
  'solutions' => 
  array (
    'check_credentials' => 'Verifica le credenziali AWS in .env',
    'check_bucket_name' => 'Verifica il nome del bucket S3',
    'check_region' => 'Verifica la regione AWS configurata',
    'check_permissions' => 'Verifica i permessi IAM per S3',
    'check_cloudfront_config' => 'Verifica la configurazione CloudFront',
    'contact_admin' => 'Contatta l\'amministratore del sistema',
  ),
  'label' => 'S3test',
  'plural_label' => 'S3test (Plurale)',
  'navigation' => 
  array (
    'name' => 'S3test',
    'plural' => 'S3test',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'S3test',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
);
