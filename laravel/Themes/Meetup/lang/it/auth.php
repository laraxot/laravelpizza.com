<?php

declare(strict_types=1);

return [
    'login' => [
        'title' => 'Bentornato su Laravel Pizza Meetups! 🍕',
        'subtitle' => 'Accedi per iscriverti ai meetup e gestire le tue prenotazioni.',
        'page_title' => 'Accedi',
    ],
    'logout' => [
        'in_progress' => 'Disconnessione in corso…',
    ],
    'password' => [
        'request' => [
            'title' => 'Password dimenticata?',
            'subtitle' => 'Scrivi l\'email del tuo account: ti mandiamo un link per sceglierne una nuova.',
            'email' => 'Email',
            'submit' => 'Inviami il link',
            'back_to_login' => 'Torna all\'accesso',
        ],
        'reset' => [
            'title' => 'Scegli una nuova password',
            'subtitle' => 'Almeno 8 caratteri. Dopo il salvataggio entri subito nel sito.',
            'email' => 'Email',
            'password' => 'Nuova password',
            'password_confirmation' => 'Ripeti la nuova password',
            'submit' => 'Salva la password',
        ],
        'confirm' => [
            'title' => 'Conferma la password',
            'subtitle' => 'È una zona protetta: per continuare scrivi di nuovo la tua password.',
            'password' => 'Password',
            'submit' => 'Conferma',
            'forgot' => 'Password dimenticata?',
        ],
    ],
    'verify' => [
        'title' => 'Controlla la tua email',
        'subtitle' => 'Ti abbiamo mandato un link per confermare l\'indirizzo email. Aprilo per completare la registrazione.',
        'resent' => 'Ti abbiamo mandato un nuovo link di conferma.',
        'resend' => 'Non è arrivata? Mandamene un\'altra',
        'logout' => 'Esci',
    ],
];
