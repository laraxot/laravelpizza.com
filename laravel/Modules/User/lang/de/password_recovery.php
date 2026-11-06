<?php

declare(strict_types=1);

/*
 * Seiten "Passwort vergessen" und "Neues Passwort" im Frontoffice (DCP-290).
 * Die Nachricht `sent` ist fuer eine registrierte und eine unbekannte Adresse gleich: Konten lassen sich nicht erraten.
 */
return [
    'title' => 'Passwort vergessen?',
    'intro' => 'Geben Sie die E-Mail-Adresse ein, mit der Sie sich registriert haben. Wir senden Ihnen einen Link, mit dem Sie ein neues Passwort wählen können.',
    'submit' => 'Link senden',
    'sent' => 'Wenn die Adresse registriert ist, erhalten Sie in Kürze eine E-Mail mit einem Link zum Wählen eines neuen Passworts. Prüfen Sie auch Ihren Spam-Ordner.',
    'back_to_login' => 'Zurück zur Anmeldung',
    'reset_title' => 'Neues Passwort wählen',
    'reset_intro' => 'Geben Sie das neue Passwort zweimal ein. Danach können Sie sich damit anmelden.',
    'reset_submit' => 'Neues Passwort speichern',
    'reset_done' => 'Ihr Passwort wurde geändert. Melden Sie sich mit dem neuen Passwort an.',
    'invalid_link' => 'Der Link ist ungültig oder abgelaufen. Fordern Sie einen neuen an.',
    'request_new' => 'Neuen Link anfordern',
    'sending' => 'Wird gesendet …',
    'saving' => 'Wird gespeichert …',
];
