<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Test S3',
    'group' => 'UI',
    'icon' => 'heroicon-o-cloud',
    'sort' => 50,
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Destinatario',
      'placeholder' => 'Inserisci email destinatario',
      'helper_text' => '',
      'description' => 'Indirizzo email del destinatario',
      'tooltip' => '',
    ),
    'subject' => 
    array (
      'label' => 'Oggetto',
      'placeholder' => 'Inserisci oggetto email',
      'helper_text' => '',
      'description' => 'Oggetto dell\'email di test',
      'tooltip' => '',
    ),
    'body_html' => 
    array (
      'label' => 'Corpo HTML',
      'placeholder' => 'Inserisci contenuto HTML',
      'helper_text' => '',
      'description' => 'Contenuto HTML dell\'email',
      'tooltip' => '',
    ),
    'attachment' => 
    array (
      'description' => 'Allegato per il test S3',
      'helper_text' => '',
      'placeholder' => 'Seleziona file da allegare',
      'label' => 'Allegato',
      'tooltip' => '',
    ),
    'debug_output' => 
    array (
      'description' => 'Output di debug per i test',
      'helper_text' => '',
      'placeholder' => 'Output debug',
      'label' => 'Debug Output',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'emailFormActions' => 
    array (
      'label' => 'Azioni Email',
      'tooltip' => 'Azioni per la gestione email',
    ),
    'save' => 
    array (
      'label' => 'Salva',
      'tooltip' => 'Salva configurazione test',
    ),
    'formActions' => 
    array (
      'label' => 'Azioni Form',
      'tooltip' => 'Azioni per la gestione form',
    ),
    'sendEmail' => 
    array (
      'label' => 'Invia Email',
      'tooltip' => 'Invia email di test',
    ),
    'runAllTests' => 
    array (
      'label' => 'Esegui Tutti i Test',
      'tooltip' => 'Esegui tutti i test S3',
    ),
    'testCloudFront' => 
    array (
      'label' => 'Test CloudFront',
      'tooltip' => 'Testa connessione CloudFront',
    ),
    'testPermissions' => 
    array (
      'label' => 'Test Permessi',
      'tooltip' => 'Testa permessi S3',
    ),
    'testS3Connection' => 
    array (
      'label' => 'Test Connessione S3',
      'tooltip' => 'Testa connessione Amazon S3',
    ),
    'testCredentials' => 
    array (
      'label' => 'Test Credenziali',
      'tooltip' => 'Testa credenziali AWS',
    ),
    'clearResults' => 
    array (
      'label' => 'Pulisci Risultati',
      'tooltip' => 'Pulisci risultati test',
    ),
    'debugConfig' => 
    array (
      'label' => 'Debug Configurazione',
      'tooltip' => 'Debug configurazione S3',
    ),
    'testBucketPolicy' => 
    array (
      'label' => 'Test Policy Bucket',
      'tooltip' => 'Testa policy del bucket S3',
    ),
    'testFileOperations' => 
    array (
      'label' => 'Test Operazioni File',
      'tooltip' => 'Testa operazioni sui file S3',
    ),
  ),
  'label' => 'S3 Test',
  'plural_label' => 'S3 Test (Plurale)',
);
