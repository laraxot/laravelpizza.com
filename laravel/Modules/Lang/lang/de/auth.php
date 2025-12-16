<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Authentication Language Lines
     * |--------------------------------------------------------------------------
     * |
     * | The following language lines are used during authentication for various
     * | messages that we need to display to the user. You are free to modify
     * | these language lines according to your application's requirements.
     * |
     */

    'failed' => 'Diese Anmeldedaten stimmen nicht mit unseren Aufzeichnungen überein.',
    'password' => 'Das angegebene Passwort ist falsch.',
    'throttle' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
    'login' => [
        'title' => 'Melden Sie sich in Ihrem Konto an',
        'email' => 'E-Mail',
        'password' => 'Passwort',
        'remember_me' => 'Angemeldet bleiben',
        'forgot_password' => 'Passwort vergessen?',
        'submit' => 'Anmelden',
        'or' => 'oder',
        'create_account' => 'ein neues Konto erstellen',
        'link' => 'Anmelden',
    ],
    'register' => [
        'title' => 'Ein neues Konto erstellen',
        'name' => 'Name',
        'email' => 'E-Mail',
        'password' => 'Passwort',
        'password_confirmation' => 'Passwort bestätigen',
        'submit' => 'Registrieren',
        'already_registered' => 'Haben Sie bereits ein Konto?',
        'link' => 'Registrieren',
    ],
    'verify' => [
        'title' => 'Bestätigen Sie Ihre E-Mail-Adresse',
        'success' => 'Ein neuer Bestätigungslink wurde an Ihre E-Mail-Adresse gesendet.',
        'notice' => 'Bitte überprüfen Sie vor dem Fortfahren Ihre E-Mail auf einen Bestätigungslink. Wenn Sie die E-Mail nicht erhalten haben,',
        'another_request' => 'klicken Sie hier, um eine andere anzufordern',
    ],
    'forgot_password' => [
        'title' => 'Passwort vergessen',
        'email' => 'E-Mail',
        'submit' => 'Reset-Link senden',
    ],
    'reset_password' => [
        'title' => 'Passwort zurücksetzen',
        'email' => 'E-Mail',
        'password' => 'Passwort',
        'password_confirmation' => 'Passwort bestätigen',
        'submit' => 'Passwort zurücksetzen',
    ],
    'confirm_password' => [
        'title' => 'Passwort bestätigen',
        'password' => 'Passwort',
        'submit' => 'Bestätigen',
    ],
    'logout' => [
        'submit' => 'Abmelden',
        'title' => 'Abmelden',
        'success_title' => 'Abmeldung erfolgreich',
        'success_message' => 'Sie wurden erfolgreich abgemeldet.',
        'error_title' => 'Fehler bei der Abmeldung',
        'error_message' => 'Bei der Abmeldung ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
        'confirm_message' => 'Sind Sie sicher, dass Sie sich abmelden möchten?',
        'confirm_button' => 'Abmeldung bestätigen',
        'cancel_button' => 'Abbrechen',
        'back_to_home' => 'Zurück zur Startseite',
        'try_again' => 'Erneut versuchen',
        'processing' => 'Abmeldung läuft...',
    ],
    'user_dropdown' => [
        'manage_account' => 'Konto verwalten',
        'profile' => 'Profil',
        'settings' => 'Einstellungen',
        'logout' => 'Abmelden',
    ],
];
