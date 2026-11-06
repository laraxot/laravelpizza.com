<?php

declare(strict_types=1);

return [
    'sections' => [
        'profile_information' => [
            'title' => 'Profilinformationen',
            'description' => 'Aktualisieren Sie die Profilinformationen und die E-Mail-Adresse Ihres Kontos.',
        ],
        'update_password' => [
            'description' => 'Stellen Sie sicher, dass Ihr Konto ein langes, zufälliges Passwort verwendet, um sicher zu bleiben.',
        ],
        'delete_account' => [
            'description' => 'Sobald Ihr Konto gelöscht ist, werden alle zugehörigen Ressourcen und Daten dauerhaft gelöscht. Laden Sie vor dem Löschen Ihres Kontos alle Daten oder Informationen herunter, die Sie behalten möchten.',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Vorname',
        ],
        'last_name' => [
            'label' => 'Nachname',
        ],
        'current_password' => [
            'label' => 'Aktuelles Passwort',
        ],
        'new_password' => [
            'label' => 'Neues Passwort',
        ],
        'confirm_new_password' => [
            'label' => 'Neues Passwort bestätigen',
        ],
    ],
    'actions' => [
        'update_profile' => [
            'label' => 'Profil aktualisieren',
        ],
        'update_password' => [
            'label' => 'Passwort aktualisieren',
        ],
        'delete_account' => [
            'label' => 'Konto löschen',
        ],
    ],
    'modal' => [
        'delete_confirmation' => [
            'title' => 'Möchten Sie Ihr Konto wirklich löschen?',
            'message' => 'Sobald Ihr Konto gelöscht ist, werden alle zugehörigen Ressourcen und Daten dauerhaft gelöscht. Bitte geben Sie Ihr Passwort ein, um zu bestätigen, dass Sie Ihr Konto dauerhaft löschen möchten.',
            'placeholder' => 'Geben Sie Ihr Passwort ein, um das Löschen zu bestätigen',
        ],
    ],
];
