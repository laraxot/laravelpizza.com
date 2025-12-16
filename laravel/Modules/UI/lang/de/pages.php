<?php

declare(strict_types=1);

return [
    's3test' => [
        'heading' => 'S3 E-Mail Test',
        'description' => 'Testseite für das Senden von E-Mails über S3',
        'info' => [
            'title' => 'Test Informationen',
            'description' => 'Diese Seite ermöglicht es Ihnen, das E-Mail-Versenden über das S3-System zu testen. Geben Sie die erforderlichen Daten ein und klicken Sie auf "E-Mail senden", um mit dem Test fortzufahren.',
        ],
        'fields' => [
            'to' => [
                'label' => 'Empfänger',
                'placeholder' => 'Geben Sie die E-Mail-Adresse des Empfängers ein',
                'helper_text' => 'Die E-Mail wird an diese Adresse gesendet',
                'description' => 'E-Mail-Adresse des Empfängers',
            ],
            'subject' => [
                'label' => 'Betreff',
                'placeholder' => 'Geben Sie den E-Mail-Betreff ein',
                'helper_text' => 'Der Betreff wird im Posteingang des Empfängers angezeigt',
                'description' => 'E-Mail-Betreff',
            ],
            'body_html' => [
                'label' => 'Inhalt',
                'placeholder' => 'Geben Sie den E-Mail-Inhalt ein',
                'helper_text' => 'Der Inhalt kann HTML-Formatierung enthalten',
                'description' => 'E-Mail-Inhalt',
            ],
        ],
        'actions' => [
            'send_email' => [
                'label' => 'E-Mail senden',
                'success' => 'E-Mail erfolgreich gesendet',
                'error' => 'Fehler beim Senden der E-Mail',
            ],
            'email_form_actions' => [
                'label' => 'Test E-Mail senden',
            ],
        ],
        'notifications' => [
            'check_email_client' => 'Überprüfen Sie Ihren E-Mail-Client',
            'email_sent_success' => 'E-Mail erfolgreich gesendet',
            'email_sent_error' => 'Fehler beim Senden der E-Mail',
        ],
    ],
];
