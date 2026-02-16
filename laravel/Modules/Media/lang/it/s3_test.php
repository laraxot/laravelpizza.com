<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 'Media',
  ),
  'fields' => 
  array (
    'debug_output' => 
    array (
      'description' => 'Output di debug per test S3',
      'label' => 'Output Debug',
      'placeholder' => 'Risultati del test verranno mostrati qui',
      'helper_text' => 'Informazioni di debug per la connessione S3',
      'tooltip' => '',
    ),
    'attachment' => 
    array (
      'label' => 'Allegato',
      'placeholder' => 'Seleziona file da caricare',
      'helper_text' => 'File da utilizzare per il test di caricamento',
      'description' => 'File di test per verificare il caricamento su S3',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'sendEmail' => 
    array (
      'label' => 'Invia Email',
    ),
    'clearResults' => 
    array (
      'label' => 'Cancella Risultati',
    ),
    'debugConfig' => 
    array (
      'label' => 'Debug Configurazione',
    ),
    'testFileOperations' => 
    array (
      'label' => 'Test Operazioni File',
    ),
    'testCredentials' => 
    array (
      'label' => 'Test Credenziali',
    ),
    'testS3Connection' => 
    array (
      'label' => 'Test Connessione S3',
    ),
    'testPermissions' => 
    array (
      'label' => 'Test Permessi',
    ),
    'testBucketPolicy' => 
    array (
      'label' => 'Test Policy Bucket',
    ),
    'testCloudFront' => 
    array (
      'label' => 'Test CloudFront',
    ),
    'test01' => 
    array (
      'label' => 'Test 01',
    ),
  ),
  'label' => 'S3 Test',
  'plural_label' => 'S3 Test (Plurale)',
);
