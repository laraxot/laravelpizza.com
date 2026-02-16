<?php

declare(strict_types=1);

return array (
  'page' => 
  array (
    'title' => 'AWS Diagnose Test',
    'heading' => 'AWS Konfiguration Diagnose',
    'description' => 'Seite zum Testen und Diagnostizieren der kompletten AWS Konfiguration',
  ),
  'fields' => 
  array (
    'cloudfront_url' => 
    array (
      'label' => 'CloudFront Distribution URL',
      'placeholder' => 'CloudFront URL eingeben',
      'helper_text' => 'URL der konfigurierten CloudFront Distribution',
      'tooltip' => '',
      'description' => '',
    ),
    'iam_user' => 
    array (
      'label' => 'IAM Benutzer/Rolle',
      'placeholder' => 'IAM Benutzer eingeben',
      'helper_text' => 'IAM Benutzer oder Rolle für AWS Zugang',
      'tooltip' => '',
      'description' => '',
    ),
    'aws_config' => 
    array (
      'label' => 'AWS Konfiguration',
      'placeholder' => 'Aktuelle AWS Konfiguration',
      'helper_text' => 'Übersicht der aktuellen AWS Konfiguration',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'test_s3_connection' => 
    array (
      'label' => 'Basis Verbindung Testen',
      'tooltip' => 'Basis Verbindung zum S3 Bucket testen',
      'success' => 'S3 Verbindung erfolgreich getestet',
      'error' => 'Fehler beim Testen der S3 Verbindung',
    ),
    'test_s3_permissions' => 
    array (
      'label' => 'Berechtigungen Testen',
      'tooltip' => 'S3 Berechtigungen testen (ListBucket, PutObject, GetObject, DeleteObject)',
      'success' => 'S3 Berechtigungen erfolgreich getestet',
      'error' => 'Fehler beim Testen der S3 Berechtigungen',
    ),
    'test_file_operations' => 
    array (
      'label' => 'Datei Operationen Testen',
      'tooltip' => 'S3 Datei Operationen testen (Upload, Download, Löschen)',
      'success' => 'Datei Operationen erfolgreich getestet',
      'error' => 'Fehler beim Testen der Datei Operationen',
    ),
    'test_cloudfront_config' => 
    array (
      'label' => 'Konfiguration Testen',
      'tooltip' => 'CloudFront Konfiguration testen',
      'success' => 'CloudFront Konfiguration erfolgreich getestet',
      'error' => 'Fehler beim Testen der CloudFront Konfiguration',
    ),
    'test_signed_urls' => 
    array (
      'label' => 'Signierte URLs Testen',
      'tooltip' => 'CloudFront signierte URL Generierung testen',
      'success' => 'Signierte URLs erfolgreich getestet',
      'error' => 'Fehler beim Testen der signierten URLs',
    ),
    'test_iam_credentials' => 
    array (
      'label' => 'Anmeldedaten Testen',
      'tooltip' => 'IAM Anmeldedaten testen',
      'success' => 'IAM Anmeldedaten erfolgreich getestet',
      'error' => 'Fehler beim Testen der IAM Anmeldedaten',
    ),
    'test_iam_policies' => 
    array (
      'label' => 'Richtlinien Testen',
      'tooltip' => 'IAM Richtlinien testen',
      'success' => 'IAM Richtlinien erfolgreich getestet',
      'error' => 'Fehler beim Testen der IAM Richtlinien',
    ),
    'run_full_diagnostic' => 
    array (
      'label' => 'Vollständige Diagnose Ausführen',
      'tooltip' => 'Alle AWS Diagnose Tests ausführen',
      'success' => 'Vollständige Diagnose erfolgreich abgeschlossen',
      'error' => 'Fehler während der vollständigen Diagnose',
    ),
  ),
  'sections' => 
  array (
    's3_connection_test' => 
    array (
      'label' => 'S3 Verbindungstest',
      'description' => 'S3 Bucket Zugang und Berechtigungen überprüfen',
    ),
    'cloudfront_test' => 
    array (
      'label' => 'CloudFront Test',
      'description' => 'CloudFront Konfiguration und signierte URLs überprüfen',
    ),
    'iam_permissions_test' => 
    array (
      'label' => 'IAM Berechtigungstest',
      'description' => 'IAM Anmeldedaten und Richtlinien überprüfen',
    ),
    'complete_diagnostic' => 
    array (
      'label' => 'Vollständige Diagnose',
      'description' => 'Alle AWS Diagnose Tests ausführen',
    ),
  ),
  'tabs' => 
  array (
    'tests' => 
    array (
      'label' => 'Tests',
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
      'label' => 'Diagnose',
    ),
  ),
  'notifications' => 
  array (
    's3_connection_successful' => 'S3 Verbindung Erfolgreich',
    's3_connection_failed' => 'S3 Verbindung Fehlgeschlagen',
    'cloudfront_config_valid' => 'CloudFront Konfiguration Gültig',
    'cloudfront_config_error' => 'CloudFront Konfiguration Fehler',
    'full_diagnostic_completed' => 'Vollständige Diagnose Abgeschlossen',
  ),
  'test_results' => 
  array (
    'status_success' => 'Erfolg',
    'status_error' => 'Fehler',
    'status_completed' => 'Abgeschlossen',
    'successfully_connected' => 'Erfolgreich mit S3 Bucket verbunden',
    'cloudfront_config_valid' => 'CloudFront Konfiguration gültig',
    'cloudfront_config_error' => 'CloudFront Konfiguration Fehler',
    'full_diagnostic_completed' => 'Vollständige Diagnose abgeschlossen',
    'check_cloudfront_settings' => 'CloudFront Einstellungen in der Konfiguration überprüfen',
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
