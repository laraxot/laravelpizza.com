<?php

declare(strict_types=1);

return [
    'passwords' => [
        'user' => [
            'label' => 'Wir können keinen Benutzer mit dieser E-Mail-Adresse finden.',
            'title' => 'Benutzer nicht gefunden',
            'description' => 'Bitte überprüfen Sie, ob die E-Mail-Adresse korrekt ist und versuchen Sie es erneut.',
        ],
        'token' => [
            'label' => 'Dieses Passwort-Reset-Token ist ungültig oder abgelaufen.',
            'title' => 'Ungültiger Token',
            'description' => 'Der Reset-Link könnte abgelaufen sein. Bitte fordern Sie einen neuen Link an.',
        ],
        'sent' => [
            'label' => 'Wir haben Ihnen einen Passwort-Reset-Link gesendet!',
            'title' => 'Link gesendet',
            'description' => 'Bitte überprüfen Sie Ihren E-Mail-Posteingang.',
        ],
        'reset' => [
            'label' => 'Ihr Passwort wurde erfolgreich zurückgesetzt!',
            'title' => 'Passwort zurückgesetzt',
            'description' => 'Sie können sich jetzt mit Ihrem neuen Passwort anmelden.',
        ],
        'throttled' => [
            'label' => 'Zu viele Passwort-Reset-Versuche. Bitte warten Sie, bevor Sie es erneut versuchen.',
            'title' => 'Zu viele Versuche',
            'description' => 'Bitte warten Sie einige Minuten, bevor Sie einen neuen Link anfordern.',
        ],
    ],
    'auth' => [
        'failed' => [
            'label' => 'Diese Anmeldedaten stimmen nicht mit unseren Aufzeichnungen überein.',
            'title' => 'Zugang verweigert',
            'description' => 'Die E-Mail oder das Passwort ist falsch.',
        ],
        'throttle' => [
            'label' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
            'title' => 'Konto vorübergehend gesperrt',
            'description' => 'Aus Sicherheitsgründen warten Sie bitte, bevor Sie es erneut versuchen.',
        ],
        'unauthorized' => [
            'label' => 'Sie haben nicht die erforderlichen Berechtigungen für diese Operation.',
            'title' => 'Unbefugter Zugriff',
            'description' => 'Wenden Sie sich an den Administrator, wenn Sie denken, dass dies ein Fehler ist.',
        ],
    ],
    'validation' => [
        'required' => [
            'label' => 'Das :attribute Feld ist erforderlich.',
            'title' => 'Pflichtfeld',
            'description' => 'Bitte füllen Sie alle erforderlichen Felder aus, um fortzufahren.',
        ],
        'email' => [
            'label' => 'Das :attribute Feld muss eine gültige E-Mail-Adresse sein.',
            'title' => 'Ungültige E-Mail',
            'description' => 'Bitte geben Sie eine E-Mail-Adresse im korrekten Format ein.',
        ],
        'min' => [
            'label' => 'Das :attribute Feld muss mindestens :min Zeichen haben.',
            'title' => 'Unzureichende Länge',
            'description' => 'Der eingegebene Wert ist zu kurz.',
        ],
    ],
];
