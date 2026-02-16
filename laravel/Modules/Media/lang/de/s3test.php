<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'testCredentials' => 
    array (
      'label' => 'AWS-Anmeldedaten testen',
      'tooltip' => 'Konfigurierte AWS-Anmeldedaten überprüfen',
    ),
    'testS3Connection' => 
    array (
      'label' => 'S3-Verbindung testen',
      'tooltip' => 'S3-Bucket-Verbindung überprüfen',
    ),
    'testPermissions' => 
    array (
      'label' => 'S3-Berechtigungen testen',
      'tooltip' => 'S3-Operationsberechtigungen überprüfen',
    ),
    'testBucketPolicy' => 
    array (
      'label' => 'Bucket-Richtlinie testen',
      'tooltip' => 'S3-Bucket-Richtlinie überprüfen',
    ),
    'testCloudFront' => 
    array (
      'label' => 'CloudFront testen',
      'tooltip' => 'CloudFront-Konfiguration überprüfen',
    ),
    'testFileOperations' => 
    array (
      'label' => 'Dateioperationen testen',
      'tooltip' => 'Datei-Upload, -Download und -Löschung testen',
    ),
    'debugConfig' => 
    array (
      'label' => 'Konfiguration debuggen',
      'tooltip' => 'Aktuelle AWS-Konfiguration anzeigen',
    ),
    'clearResults' => 
    array (
      'label' => 'Ergebnisse löschen',
      'tooltip' => 'Alle Testergebnisse löschen',
    ),
    'sendEmail' => 
    array (
      'label' => 'Test-E-Mail senden',
      'tooltip' => 'E-Mail mit Anhang zum Testen senden',
    ),
  ),
  'notifications' => 
  array (
    'credentials_tested' => 'AWS-Anmeldedaten getestet',
    'bucket_policy_tested' => 'Bucket-Richtlinie getestet',
    'file_operations_tested' => 'Dateioperationen getestet',
    'config_debugged' => 'Konfiguration analysiert',
    'results_cleared' => 'Ergebnisse gelöscht',
    's3_test_successful' => 'S3-Test erfolgreich abgeschlossen',
    'operations_completed' => 'Alle Operationen abgeschlossen',
    'test_failed' => 'Test fehlgeschlagen',
    'no_attachment' => 'Kein Anhang ausgewählt',
    'upload_file_first' => 'Laden Sie zuerst eine Datei zum Testen hoch',
    'email_sent' => 'Test-E-Mail gesendet',
    'email_with_attachment' => 'E-Mail mit Anhang erfolgreich gesendet',
    'email_failed' => 'E-Mail-Versand fehlgeschlagen',
  ),
  'debug' => 
  array (
    'run_tests_message' => 'Führen Sie Tests aus, um Ergebnisse hier zu sehen...',
  ),
  'fields' => 
  array (
    'attachment' => 
    array (
      'label' => 'Anhang',
      'placeholder' => 'Wählen Sie eine Datei zum Anhängen',
      'helper_text' => 'Testdatei zur Überprüfung der S3-Operationen',
      'tooltip' => '',
      'description' => '',
    ),
    'debug_output' => 
    array (
      'label' => 'Debug-Ausgabe',
      'placeholder' => 'Testergebnisse werden hier angezeigt',
      'helper_text' => 'Detaillierte Ausgabe der ausgeführten Tests',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'messages' => 
  array (
    'test_successful' => 'Test erfolgreich abgeschlossen',
    'test_failed' => 'Test fehlgeschlagen',
    'configuration_valid' => 'Gültige Konfiguration',
    'configuration_invalid' => 'Ungültige Konfiguration',
    'permissions_ok' => 'Berechtigungen überprüft',
    'permissions_failed' => 'Unzureichende Berechtigungen',
    'connection_ok' => 'Verbindung hergestellt',
    'connection_failed' => 'Verbindung fehlgeschlagen',
  ),
  'errors' => 
  array (
    'aws_credentials_invalid' => 'Ungültige AWS-Anmeldedaten',
    's3_bucket_inaccessible' => 'S3-Bucket nicht zugänglich',
    'cloudfront_config_incomplete' => 'Unvollständige CloudFront-Konfiguration',
    'file_operations_failed' => 'Dateioperationen fehlgeschlagen',
    'permissions_insufficient' => 'Unzureichende Berechtigungen',
    'unknown_error' => 'Unbekannter Fehler',
  ),
  'solutions' => 
  array (
    'check_credentials' => 'Überprüfen Sie die AWS-Anmeldedaten in .env',
    'check_bucket_name' => 'Überprüfen Sie den S3-Bucket-Namen',
    'check_region' => 'Überprüfen Sie die konfigurierte AWS-Region',
    'check_permissions' => 'Überprüfen Sie die IAM-Berechtigungen für S3',
    'check_cloudfront_config' => 'Überprüfen Sie die CloudFront-Konfiguration',
    'contact_admin' => 'Kontaktieren Sie den Systemadministrator',
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
