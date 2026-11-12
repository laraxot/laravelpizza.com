<?php

declare(strict_types=1);

// Pagina "Modifica il profilo" (/{lingua}/profile/edit): Modules\Meetup\Http\Livewire\ProfileEditForm
return [
    'link' => 'Profil bearbeiten',
    'sections' => [
        'data' => ['title' => 'Deine Daten', 'description' => 'Name und Bio erscheinen in deinem öffentlichen Profil und in Teilnehmerlisten.'],
        'photo' => ['title' => 'Foto', 'description' => 'Optional. Ohne Foto zeigen wir deine Initialen.'],
        'password' => ['title' => 'Passwort', 'description' => 'Gib zuerst dein aktuelles Passwort ein. Andere offene Sitzungen werden abgemeldet.'],
    ],
    'fields' => [
        'first_name' => 'Vorname',
        'last_name' => 'Nachname',
        'email' => 'E-Mail',
        'bio' => 'Über mich',
        'locale' => 'Bevorzugte Sprache',
        'photo' => 'Neues Foto',
        'current_password' => 'Aktuelles Passwort',
        'password' => 'Neues Passwort',
        'password_confirmation' => 'Neues Passwort wiederholen',
    ],
    'help' => [
        'email' => 'Die E-Mail-Adresse kannst du hier nicht ändern: schreib uns über die Kontaktseite.',
        'bio' => 'Höchstens 500 Zeichen. Für alle sichtbar.',
        'locale' => 'Die Sprache unserer E-Mails an dich.',
        'photo' => 'JPG, PNG oder WebP, höchstens 2 MB.',
    ],
    'placeholders' => [
        'bio' => 'Ein paar Zeilen über dich: was du machst, womit du arbeitest, was du lernen möchtest.',
    ],
    'actions' => [
        'save_profile' => 'Daten speichern',
        'view_public' => 'Öffentliches Profil ansehen',
        'save_photo' => 'Foto hochladen',
        'remove_photo' => 'Foto entfernen',
        'change_password' => 'Passwort ändern',
    ],
    'saved' => [
        'profile' => 'Daten gespeichert.',
        'photo' => 'Foto aktualisiert.',
        'password' => 'Passwort geändert.',
    ],
    'photo' => [
        'uploading' => 'Wird hochgeladen…',
        'preview_alt' => 'Vorschau des neuen Fotos',
        'current_alt' => 'Dein aktuelles Foto',
    ],
];
