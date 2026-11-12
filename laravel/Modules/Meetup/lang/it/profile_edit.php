<?php

declare(strict_types=1);

// Pagina "Modifica il profilo" (/{lingua}/profile/edit): Modules\Meetup\Http\Livewire\ProfileEditForm
return [
    'link' => 'Modifica il profilo',
    'sections' => [
        'data' => ['title' => 'I tuoi dati', 'description' => 'Nome e biografia compaiono nel tuo profilo pubblico e nell\'elenco dei partecipanti.'],
        'photo' => ['title' => 'Foto', 'description' => 'Facoltativa. Senza foto mostriamo le tue iniziali.'],
        'password' => ['title' => 'Password', 'description' => 'Per cambiarla scrivi prima quella attuale. Le altre sessioni aperte verranno chiuse.'],
    ],
    'fields' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'Email',
        'bio' => 'Biografia',
        'locale' => 'Lingua preferita',
        'photo' => 'Nuova foto',
        'current_password' => 'Password attuale',
        'password' => 'Nuova password',
        'password_confirmation' => 'Ripeti la nuova password',
    ],
    'help' => [
        'email' => 'L\'email non si cambia da qui: scrivici dalla pagina Contatti se ti serve.',
        'bio' => 'Massimo 500 caratteri. Visibile a tutti.',
        'locale' => 'La lingua delle email che ti mandiamo.',
        'photo' => 'JPG, PNG o WebP, massimo 2 MB.',
    ],
    'placeholders' => [
        'bio' => 'Due righe su di te: cosa fai, con cosa lavori, cosa ti piacerebbe imparare.',
    ],
    'actions' => [
        'save_profile' => 'Salva i dati',
        'view_public' => 'Guarda il profilo pubblico',
        'save_photo' => 'Carica la foto',
        'remove_photo' => 'Togli la foto',
        'change_password' => 'Cambia la password',
    ],
    'saved' => [
        'profile' => 'Dati salvati.',
        'photo' => 'Foto aggiornata.',
        'password' => 'Password cambiata.',
    ],
    'photo' => [
        'uploading' => 'Caricamento in corso…',
        'preview_alt' => 'Anteprima della nuova foto',
        'current_alt' => 'La tua foto attuale',
    ],
];
