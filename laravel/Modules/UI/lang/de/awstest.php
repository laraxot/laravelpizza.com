<?php

declare(strict_types=1);

return [
    'page' => [
        'title' => 'AWS Diagnose Test',
        'heading' => 'AWS Konfiguration Diagnose',
        'description' => 'Seite zum Testen und Diagnostizieren der kompletten AWS Konfiguration',
    ],
    'fields' => [
        'cloudfront_url' => [
            'label' => 'CloudFront Distribution URL',
            'placeholder' => 'CloudFront URL eingeben',
            'helper_text' => 'URL der konfigurierten CloudFront Distribution',
        ],
        'iam_user' => [
            'label' => 'IAM Benutzer/Rolle',
            'placeholder' => 'IAM Benutzer eingeben',
            'helper_text' => 'IAM Benutzer oder Rolle für AWS Zugang',
        ],
        'aws_config' => [
            'label' => 'AWS Konfiguration',
            'placeholder' => 'Aktuelle AWS Konfiguration',
            'helper_text' => 'Übersicht der aktuellen AWS Konfiguration',
        ],
    ],
    'actions' => [
        'test_s3_connection' => [
            'label' => 'Basis Verbindung Testen',
            'tooltip' => 'Basis Verbindung zum S3 Bucket testen',
            'success' => 'S3 Verbindung erfolgreich getestet',
            'error' => 'Fehler beim Testen der S3 Verbindung',
        ],
        'test_s3_permissions' => [
            'label' => 'Berechtigungen Testen',
            'tooltip' => 'S3 Berechtigungen testen (ListBucket, PutObject, GetObject, DeleteObject)',
            'success' => 'S3 Berechtigungen erfolgreich getestet',
            'error' => 'Fehler beim Testen der S3 Berechtigungen',
        ],
        'test_file_operations' => [
            'label' => 'Datei Operationen Testen',
            'tooltip' => 'S3 Datei Operationen testen (Upload, Download, Löschen)',
            'success' => 'Datei Operationen erfolgreich getestet',
            'error' => 'Fehler beim Testen der Datei Operationen',
        ],
        'test_cloudfront_config' => [
            'label' => 'Konfiguration Testen',
            'tooltip' => 'CloudFront Konfiguration testen',
            'success' => 'CloudFront Konfiguration erfolgreich getestet',
            'error' => 'Fehler beim Testen der CloudFront Konfiguration',
        ],
        'test_signed_urls' => [
            'label' => 'Signierte URLs Testen',
            'tooltip' => 'CloudFront signierte URL Generierung testen',
            'success' => 'Signierte URLs erfolgreich getestet',
            'error' => 'Fehler beim Testen der signierten URLs',
        ],
        'test_iam_credentials' => [
            'label' => 'Anmeldedaten Testen',
            'tooltip' => 'IAM Anmeldedaten testen',
            'success' => 'IAM Anmeldedaten erfolgreich getestet',
            'error' => 'Fehler beim Testen der IAM Anmeldedaten',
        ],
        'test_iam_policies' => [
            'label' => 'Richtlinien Testen',
            'tooltip' => 'IAM Richtlinien testen',
            'success' => 'IAM Richtlinien erfolgreich getestet',
            'error' => 'Fehler beim Testen der IAM Richtlinien',
        ],
        'run_full_diagnostic' => [
            'label' => 'Vollständige Diagnose Ausführen',
            'tooltip' => 'Alle AWS Diagnose Tests ausführen',
            'success' => 'Vollständige Diagnose erfolgreich abgeschlossen',
            'error' => 'Fehler während der vollständigen Diagnose',
        ],
    ],
    'sections' => [
        's3_connection_test' => [
            'label' => 'S3 Verbindungstest',
            'description' => 'S3 Bucket Zugang und Berechtigungen überprüfen',
        ],
        'cloudfront_test' => [
            'label' => 'CloudFront Test',
            'description' => 'CloudFront Konfiguration und signierte URLs überprüfen',
        ],
        'iam_permissions_test' => [
            'label' => 'IAM Berechtigungstest',
            'description' => 'IAM Anmeldedaten und Richtlinien überprüfen',
        ],
        'complete_diagnostic' => [
            'label' => 'Vollständige Diagnose',
            'description' => 'Alle AWS Diagnose Tests ausführen',
        ],
    ],
    'tabs' => [
        'tests' => [
            'label' => 'Tests',
        ],
        's3' => [
            'label' => 'S3',
        ],
        'cloudfront' => [
            'label' => 'CloudFront',
        ],
        'iam' => [
            'label' => 'IAM',
        ],
        'diagnostics' => [
            'label' => 'Diagnose',
        ],
    ],
    'notifications' => [
        's3_connection_successful' => 'S3 Verbindung Erfolgreich',
        's3_connection_failed' => 'S3 Verbindung Fehlgeschlagen',
        'cloudfront_config_valid' => 'CloudFront Konfiguration Gültig',
        'cloudfront_config_error' => 'CloudFront Konfiguration Fehler',
        'full_diagnostic_completed' => 'Vollständige Diagnose Abgeschlossen',
    ],
    'test_results' => [
        'status_success' => 'Erfolg',
        'status_error' => 'Fehler',
        'status_completed' => 'Abgeschlossen',
        'successfully_connected' => 'Erfolgreich mit S3 Bucket verbunden',
        'cloudfront_config_valid' => 'CloudFront Konfiguration gültig',
        'cloudfront_config_error' => 'CloudFront Konfiguration Fehler',
        'full_diagnostic_completed' => 'Vollständige Diagnose abgeschlossen',
        'check_cloudfront_settings' => 'CloudFront Einstellungen in der Konfiguration überprüfen',
    ],
];
