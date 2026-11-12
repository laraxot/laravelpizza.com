<?php

declare(strict_types=1);

return [
    'login' => [
        'title' => 'Willkommen zurück bei Laravel Pizza Meetups! 🍕',
        'subtitle' => 'Melde dich an, um an Meetups teilzunehmen und deine Anmeldungen zu verwalten.',
        'page_title' => 'Anmelden',
    ],
    'logout' => [
        'in_progress' => 'Abmeldung läuft…',
    ],
    'password' => [
        'request' => [
            'title' => 'Passwort vergessen?',
            'subtitle' => 'Gib die E-Mail-Adresse deines Kontos ein. Wir senden dir einen Link für ein neues Passwort.',
            'email' => 'E-Mail',
            'submit' => 'Link senden',
            'back_to_login' => 'Zurück zur Anmeldung',
        ],
        'reset' => [
            'title' => 'Neues Passwort wählen',
            'subtitle' => 'Mindestens 8 Zeichen. Nach dem Speichern bist du direkt angemeldet.',
            'email' => 'E-Mail',
            'password' => 'Neues Passwort',
            'password_confirmation' => 'Neues Passwort wiederholen',
            'submit' => 'Passwort speichern',
        ],
        'confirm' => [
            'title' => 'Passwort bestätigen',
            'subtitle' => 'Geschützter Bereich: Gib dein Passwort erneut ein, um fortzufahren.',
            'password' => 'Passwort',
            'submit' => 'Bestätigen',
            'forgot' => 'Passwort vergessen?',
        ],
    ],
    'verify' => [
        'title' => 'Prüfe deine E-Mails',
        'subtitle' => 'Wir haben dir einen Link zur Bestätigung deiner E-Mail-Adresse gesendet.',
        'resent' => 'Wir haben dir einen neuen Bestätigungslink gesendet.',
        'resend' => 'Nichts angekommen? Neuen Link senden',
        'logout' => 'Abmelden',
    ],
];
