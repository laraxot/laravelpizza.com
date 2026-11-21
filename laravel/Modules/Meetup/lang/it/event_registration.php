<?php

declare(strict_types=1);

return [
    'actions' => [
        'register' => 'Iscriviti all\'evento',
        'login_to_register' => 'Accedi per iscriverti',
        'unregister' => 'Annulla iscrizione',
        'loading' => 'Un attimo…',
    ],
    'state' => [
        'registered' => 'Sei iscritto a questo evento.',
        'full' => 'Posti esauriti: l\'evento ha raggiunto la capienza massima.',
        'spots_left' => '{0} Nessun posto disponibile|{1} Resta :count posto|[2,*] Restano :count posti',
    ],
    'messages' => [
        'registered_new_account' => 'Account creato e iscrizione confermata! Ti abbiamo inviato il riepilogo e il link per verificare l\'email.',
        'registered' => 'Iscrizione confermata! Ti abbiamo inviato un\'email di riepilogo.',
        'unregistered' => 'Iscrizione annullata.',
        'full' => 'Ci dispiace, l\'evento è al completo.',
        'already_registered' => 'Risulti già iscritto a questo evento.',
        'not_registered' => 'Non risulti iscritto a questo evento.',
        'started' => 'L\'evento è già iniziato: le iscrizioni sono chiuse.',
        'closed' => 'Le iscrizioni per questo evento non sono aperte.',
    ],
    'signup' => [
        'intro' => 'Bastano email e password: se non hai un account lo creiamo adesso.',
        'email' => 'Email',
        'password' => 'Password',
        'password_hint' => 'Per un account nuovo: almeno :min caratteri, con maiuscole, minuscole, un numero e un simbolo.',
        'consents' => 'Accetto l\':privacy e i :terms.',
        'privacy' => 'informativa privacy',
        'terms' => 'termini di servizio',
        'consents_required' => 'Per creare l\'account devi accettare l\'informativa privacy e i termini.',
        'email_taken' => 'Questa email ha già un account e la password non corrisponde. Riprova o accedi.',
        'have_account' => 'Hai già un account?',
        'login' => 'Accedi',
        'throttle' => 'Troppi tentativi. Riprova tra :seconds secondi.',
    ],
    'mail' => [
        'subject' => 'Iscrizione confermata: :title',
        'greeting' => 'Ciao!',
        'intro' => 'La tua iscrizione a ":title" è confermata.',
        'date' => 'Quando: :date',
        'venue' => 'Dove: :venue',
        'action' => 'Vedi l\'evento',
    ],
    'reminder' => [
        'subject' => 'Domani: :title',
        'intro' => 'Ti ricordiamo che domani c\'è ":title". Ti aspettiamo!',
        'cant_come' => 'Non puoi più venire? Annulla l\'iscrizione dalla pagina dell\'evento: il posto andrà a qualcun altro.',
    ],
    'add_to_calendar' => 'Aggiungi al calendario',
];
