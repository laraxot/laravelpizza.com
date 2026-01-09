<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'users' => [
                'activate' => 'Aktivieren',
                'change_password' => 'Passwort Ändern',
                'deactivate' => 'Deaktivieren',
                'delete_permanently' => 'Permanent löschen',
                'login_as' => 'Login As :user',
                'resend_email' => 'Aktivierungsmail erneut senden',
                'restore_user' => 'Benutzer wiederherstellen',
            ],
        ],
    ],
    'emails' => [
        'auth' => [
            'confirm_account' => 'Confirm Account',
            'reset_password' => 'Reset Password',
        ],
    ],
    'general' => [
        'cancel' => 'Abbrechen',
        'crud' => [
            'create' => 'Erstellen',
            'delete' => 'Löschen',
            'edit' => 'Bearbeiten',
            'update' => 'Aktualisieren',
            'view' => 'View',
        ],
        'save' => 'Speichern',
        'view' => 'Anzeigen',
    ],
];
