<?php

declare(strict_types=1);

return [
    'page' => [
        'title' => 'S3 und CloudFront Test',
        'heading' => 'AWS Konfiguration Test',
        'description' => 'Seite zum Testen der S3 und CloudFront Konfiguration',
    ],
    'fields' => [
        'attachment' => [
            'label' => 'Test Datei',
            'placeholder' => 'Datei hochladen um S3 zu testen',
            'helper_text' => 'Datei wird zu S3 hochgeladen um die Konfiguration zu testen',
        ],
        'debug_output' => [
            'label' => 'Debug Ergebnisse',
            'placeholder' => 'Test Ergebnisse erscheinen hier',
            'helper_text' => 'Detaillierte Ausgabe der AWS Konfigurationstests',
        ],
    ],
    'actions' => [
        'testS3Connection' => [
            'label' => '🔍 S3 Verbindung Testen',
            'tooltip' => 'Verbindung zum S3 Bucket testen',
            'success' => 'S3 Verbindung erfolgreich getestet',
            'error' => 'Fehler beim Testen der S3 Verbindung',
        ],
        'testPermissions' => [
            'label' => '🔒 Berechtigungen Testen',
            'tooltip' => 'S3 Berechtigungen testen (ListBucket, PutObject, GetObject, DeleteObject)',
            'success' => 'S3 Berechtigungen erfolgreich getestet',
            'error' => 'Fehler beim Testen der S3 Berechtigungen',
        ],
        'testCloudFront' => [
            'label' => '☁️ CloudFront Testen',
            'tooltip' => 'CloudFront Konfiguration und signierte URL Generierung testen',
            'success' => 'CloudFront erfolgreich getestet',
            'error' => 'Fehler beim Testen von CloudFront',
        ],
        'runAllTests' => [
            'label' => '🚀 Alle Tests Ausführen',
            'tooltip' => 'Alle AWS Konfigurationstests ausführen',
            'success' => 'Alle Tests erfolgreich abgeschlossen',
            'error' => 'Fehler beim Ausführen der Tests',
        ],
        'sendEmail' => [
            'label' => '📧 E-Mail Senden',
            'tooltip' => 'E-Mail Versand mit S3 Anhang testen',
            'success' => 'E-Mail erfolgreich gesendet',
            'error' => 'Fehler beim Senden der E-Mail',
        ],
    ],
    'notifications' => [
        'all_tests_completed' => 'Alle Tests abgeschlossen',
        's3_test_successful' => '✅ S3 und CloudFront Test erfolgreich abgeschlossen!',
        'test_failed' => '❌ Test fehlgeschlagen',
        'operations_completed' => 'Alle Operationen erfolgreich abgeschlossen',
    ],
    'debug' => [
        'run_tests_message' => 'Tests ausführen um Ergebnisse zu sehen...',
        'configuration_title' => '📋 Konfiguration',
        'credentials_title' => '🔐 AWS Anmeldedaten',
        's3_connection_title' => '☁️ S3 Verbindung',
        'permissions_title' => '🔒 S3 Berechtigungen',
        'bucket_policy_title' => '📜 Bucket Richtlinie',
        'cloudfront_title' => '☁️ CloudFront',
        'status_success' => 'Erfolg',
        'status_error' => 'Fehler',
        'status_info' => 'Info',
        'present' => '✅ Vorhanden',
        'missing' => '❌ Fehlend',
        'yes' => '✅ Ja',
        'no' => '❌ Nein',
        'ok' => '✅ OK',
        'complete' => '✅ Vollständig',
        'incomplete' => '❌ Unvollständig',
    ],
];
