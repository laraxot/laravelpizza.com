<?php

declare(strict_types=1);

return array (
  'page' => 
  array (
    'title' => 'Test AWS Diagnostico',
    'heading' => 'Diagnostica Configurazione AWS',
    'description' => 'Pagina per testare e diagnosticare la configurazione AWS completa',
  ),
  'fields' => 
  array (
    'cloudfront_url' => 
    array (
      'label' => 'URL Distribuzione CloudFront',
      'placeholder' => 'Inserisci URL CloudFront',
      'helper_text' => 'URL della distribuzione CloudFront configurata',
      'tooltip' => '',
      'description' => '',
    ),
    'iam_user' => 
    array (
      'label' => 'Utente/Ruolo IAM',
      'placeholder' => 'Inserisci utente IAM',
      'helper_text' => 'Utente o ruolo IAM utilizzato per l\'accesso AWS',
      'tooltip' => '',
      'description' => '',
    ),
    'aws_config' => 
    array (
      'label' => 'Configurazione AWS',
      'placeholder' => 'Configurazione AWS corrente',
      'helper_text' => 'Panoramica della configurazione AWS attuale',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'test_s3_connection' => 
    array (
      'label' => 'Test Connessione Base',
      'tooltip' => 'Testa la connessione base al bucket S3',
      'success' => 'Connessione S3 testata con successo',
      'error' => 'Errore nel test della connessione S3',
    ),
    'test_s3_permissions' => 
    array (
      'label' => 'Test Permessi',
      'tooltip' => 'Testa i permessi S3 (ListBucket, PutObject, GetObject, DeleteObject]',
      'success' => 'Permessi S3 testati con successo',
      'error' => 'Errore nel test dei permessi S3',
    ),
    'test_file_operations' => 
    array (
      'label' => 'Test Operazioni File',
      'tooltip' => 'Testa le operazioni sui file S3 (upload, download, delete]',
      'success' => 'Operazioni file testate con successo',
      'error' => 'Errore nel test delle operazioni file',
    ),
    'test_cloudfront_config' => 
    array (
      'label' => 'Test Configurazione',
      'tooltip' => 'Testa la configurazione CloudFront',
      'success' => 'Configurazione CloudFront testata con successo',
      'error' => 'Errore nel test della configurazione CloudFront',
    ),
    'test_signed_urls' => 
    array (
      'label' => 'Test URL Firmati',
      'tooltip' => 'Testa la generazione di URL firmati CloudFront',
      'success' => 'URL firmati testati con successo',
      'error' => 'Errore nel test degli URL firmati',
    ),
    'test_iam_credentials' => 
    array (
      'label' => 'Test Credenziali',
      'tooltip' => 'Testa le credenziali IAM',
      'success' => 'Credenziali IAM testate con successo',
      'error' => 'Errore nel test delle credenziali IAM',
    ),
    'test_iam_policies' => 
    array (
      'label' => 'Test Policy',
      'tooltip' => 'Testa le policy IAM',
      'success' => 'Policy IAM testate con successo',
      'error' => 'Errore nel test delle policy IAM',
    ),
    'run_full_diagnostic' => 
    array (
      'label' => 'Esegui Diagnostica Completa',
      'tooltip' => 'Esegue tutti i test diagnostici AWS',
      'success' => 'Diagnostica completa eseguita con successo',
      'error' => 'Errore durante la diagnostica completa',
    ),
  ),
  'sections' => 
  array (
    's3_connection_test' => 
    array (
      'label' => 'Test Connessione S3',
      'description' => 'Verifica accesso al bucket S3 e permessi',
    ),
    'cloudfront_test' => 
    array (
      'label' => 'Test CloudFront',
      'description' => 'Verifica configurazione CloudFront e URL firmati',
    ),
    'iam_permissions_test' => 
    array (
      'label' => 'Test Permessi IAM',
      'description' => 'Verifica credenziali e policy IAM',
    ),
    'complete_diagnostic' => 
    array (
      'label' => 'Diagnostica Completa',
      'description' => 'Esegue tutti i test diagnostici AWS',
    ),
  ),
  'tabs' => 
  array (
    'tests' => 
    array (
      'label' => 'Test',
    ),
    's3' => 
    array (
      'label' => 'S3',
    ),
    'cloudfront' => 
    array (
      'label' => 'CloudFront',
    ),
    'iam' => 
    array (
      'label' => 'IAM',
    ),
    'diagnostics' => 
    array (
      'label' => 'Diagnostica',
    ),
  ),
  'notifications' => 
  array (
    's3_connection_successful' => 'Connessione S3 riuscita',
    's3_connection_failed' => 'Connessione S3 fallita',
    'cloudfront_config_valid' => 'Configurazione CloudFront valida',
    'cloudfront_config_error' => 'Errore configurazione CloudFront',
    'full_diagnostic_completed' => 'Diagnostica completa completata',
  ),
  'test_results' => 
  array (
    'status_success' => 'successo',
    'status_error' => 'errore',
    'status_completed' => 'completato',
    'successfully_connected' => 'Connesso con successo al bucket S3',
    'cloudfront_config_valid' => 'Configurazione CloudFront valida',
    'cloudfront_config_error' => 'Errore configurazione CloudFront',
    'full_diagnostic_completed' => 'Diagnostica completa completata',
    'check_cloudfront_settings' => 'Controlla le impostazioni CloudFront nella configurazione',
  ),
  'label' => 'Awstest',
  'plural_label' => 'Awstest (Plurale)',
  'navigation' => 
  array (
    'name' => 'Awstest',
    'plural' => 'Awstest',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Awstest',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
);
