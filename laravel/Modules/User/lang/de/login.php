<?php

declare(strict_types=1);

return [
    'logout_in_progress' => 'Abmeldung läuft…',
    'fields' => [
        'email' => [
            'label' => 'E-Mail-Adresse',
            'placeholder' => 'E-Mail-Adresse eingeben',
            'help' => 'Geben Sie die E-Mail-Adresse Ihres Kontos ein',
            'description' => 'E-Mail',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'password' => [
            'label' => 'Passwort',
            'placeholder' => 'Passwort eingeben',
            'help' => 'Geben Sie das Passwort Ihres Kontos ein',
            'description' => 'Passwort',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'remember' => [
            'label' => 'Angemeldet bleiben',
            'placeholder' => '',
            'help' => 'Auf diesem Gerät angemeldet bleiben',
            'description' => 'Angemeldet bleiben',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'name' => [
            'label' => 'Vollständiger Name',
            'placeholder' => 'Geben Sie Ihren vollständigen Namen ein',
            'help' => 'Ihr vollständiger Name für die Registrierung',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password_confirmation' => [
            'label' => 'Passwort bestätigen',
            'placeholder' => 'Passwort wiederholen',
            'help' => 'Wiederholen Sie das Passwort zur Bestätigung',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Anmelden',
            'success' => 'Anmeldung erfolgreich',
            'error' => 'Ungültige Zugangsdaten',
            'throttle' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
        ],
        'register' => [
            'label' => 'Registrieren',
            'success' => 'Registrierung abgeschlossen',
            'error' => 'Die Registrierung konnte nicht abgeschlossen werden',
        ],
        'forgot_password' => [
            'label' => 'Passwort vergessen?',
            'success' => 'Anweisungen zum Zurücksetzen wurden an Ihre E-Mail-Adresse gesendet',
            'error' => 'Die Anweisungen konnten nicht gesendet werden',
        ],
        'reset_password' => [
            'label' => 'Passwort zurücksetzen',
            'success' => 'Passwort erfolgreich zurückgesetzt',
            'error' => 'Das Passwort konnte nicht zurückgesetzt werden',
        ],
    ],
    'no_account' => 'Sie haben noch kein Konto?',
    'register_now' => 'Jetzt registrieren',
    'forgot_password_text' => 'Passwort vergessen?',
    'reset_it' => 'Zurücksetzen',
    'messages' => [
        'logout_success' => 'Abmeldung erfolgreich',
        'logout_error' => 'Bei der Abmeldung ist ein Fehler aufgetreten',
        'user_not_allowed' => 'Ihre E-Mail-Adresse ist nicht berechtigt',
        'registration_not_enabled' => 'Die Benutzerregistrierung ist nicht erlaubt',
        'throttle' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
        'general_error' => 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.',
        'unauthorized' => 'Sie haben keine Berechtigung für diesen Vorgang.',
    ],
    'password_reset_page' => [
        'title' => 'Passwort zurücksetzen',
        'intro' => 'Geben Sie Ihre E-Mail-Adresse ein. Wir senden Ihnen einen Link, mit dem Sie ein neues Passwort festlegen können.',
        'email_label' => 'E-Mail-Adresse',
        'submit' => 'Link zum Zurücksetzen senden',
        'return_to_login' => 'Zurück zur Anmeldung',
    ],
    'page' => [
        'title' => 'Bei FixCity anmelden',
        'subtitle' => 'Melden Sie sich an, um ein Problem zu melden und Ihre Vorgänge zu verfolgen',
    ],
    'already_registered' => 'Sie haben noch kein Konto?',
    'register' => 'Jetzt registrieren',
];
