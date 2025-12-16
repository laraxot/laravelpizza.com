<?php

declare(strict_types=1);

return [
    'actions' => [
        'testCredentials' => [
            'label' => 'AWS-Anmeldedaten testen',
            'tooltip' => 'Konfigurierte AWS-Anmeldedaten überprüfen',
        ],
        'testS3Connection' => [
            'label' => 'S3-Verbindung testen',
            'tooltip' => 'S3-Bucket-Verbindung überprüfen',
        ],
        'testPermissions' => [
            'label' => 'S3-Berechtigungen testen',
            'tooltip' => 'S3-Operationsberechtigungen überprüfen',
        ],
        'testBucketPolicy' => [
            'label' => 'Bucket-Richtlinie testen',
            'tooltip' => 'S3-Bucket-Richtlinie überprüfen',
        ],
        'testCloudFront' => [
            'label' => 'CloudFront testen',
            'tooltip' => 'CloudFront-Konfiguration überprüfen',
        ],
        'testFileOperations' => [
            'label' => 'Dateioperationen testen',
            'tooltip' => 'Datei-Upload, -Download und -Löschung testen',
        ],
        'debugConfig' => [
            'label' => 'Konfiguration debuggen',
            'tooltip' => 'Aktuelle AWS-Konfiguration anzeigen',
        ],
        'clearResults' => [
            'label' => 'Ergebnisse löschen',
            'tooltip' => 'Alle Testergebnisse löschen',
        ],
        'sendEmail' => [
            'label' => 'Test-E-Mail senden',
            'tooltip' => 'E-Mail mit Anhang zum Testen senden',
        ],
    ],
    'notifications' => [
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
    ],
    'debug' => [
        'run_tests_message' => 'Führen Sie Tests aus, um Ergebnisse hier zu sehen...',
    ],
    'fields' => [
        'attachment' => [
            'label' => 'Anhang',
            'placeholder' => 'Wählen Sie eine Datei zum Anhängen',
            'helper_text' => 'Testdatei zur Überprüfung der S3-Operationen',
        ],
        'debug_output' => [
            'label' => 'Debug-Ausgabe',
            'placeholder' => 'Testergebnisse werden hier angezeigt',
            'helper_text' => 'Detaillierte Ausgabe der ausgeführten Tests',
        ],
    ],
    'messages' => [
        'test_successful' => 'Test erfolgreich abgeschlossen',
        'test_failed' => 'Test fehlgeschlagen',
        'configuration_valid' => 'Gültige Konfiguration',
        'configuration_invalid' => 'Ungültige Konfiguration',
        'permissions_ok' => 'Berechtigungen überprüft',
        'permissions_failed' => 'Unzureichende Berechtigungen',
        'connection_ok' => 'Verbindung hergestellt',
        'connection_failed' => 'Verbindung fehlgeschlagen',
    ],
    'errors' => [
        'aws_credentials_invalid' => 'Ungültige AWS-Anmeldedaten',
        's3_bucket_inaccessible' => 'S3-Bucket nicht zugänglich',
        'cloudfront_config_incomplete' => 'Unvollständige CloudFront-Konfiguration',
        'file_operations_failed' => 'Dateioperationen fehlgeschlagen',
        'permissions_insufficient' => 'Unzureichende Berechtigungen',
        'unknown_error' => 'Unbekannter Fehler',
    ],
    'solutions' => [
        'check_credentials' => 'Überprüfen Sie die AWS-Anmeldedaten in .env',
        'check_bucket_name' => 'Überprüfen Sie den S3-Bucket-Namen',
        'check_region' => 'Überprüfen Sie die konfigurierte AWS-Region',
        'check_permissions' => 'Überprüfen Sie die IAM-Berechtigungen für S3',
        'check_cloudfront_config' => 'Überprüfen Sie die CloudFront-Konfiguration',
        'contact_admin' => 'Kontaktieren Sie den Systemadministrator',
    ],
];
