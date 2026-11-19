<?php

declare(strict_types=1);

// Chat dell'assistente AI (components/ui/assistant.blade.php e resources/js/assistant.js).
return [
    'open' => 'Chiedi all\'assistente',
    'title' => 'Assistente Laravel Pizza',
    'subtitle' => 'Trova un meetup e iscriviti chattando',
    'close' => 'Chiudi l\'assistente',
    'welcome' => 'Ciao! Posso cercare i meetup, dirti a quali sei iscritto e iscriverti (ti chiedo sempre conferma prima).',
    'suggestions' => [
        'Quali sono i prossimi meetup?',
        'A quali eventi sono iscritto?',
        'Ci sono meetup a Milano?',
    ],
    'input_label' => 'Scrivi un messaggio all\'assistente',
    'placeholder' => 'Scrivi una domanda…',
    'send' => 'Invia',
    'thinking' => 'Sto pensando…',
    'waiting' => 'In attesa della tua conferma.',
    'confirm_title' => 'Conferma richiesta',
    'confirm' => 'Conferma',
    'cancel' => 'Annulla',
    'approved' => 'Confermato.',
    'refused' => 'Annullato: non ho fatto nulla.',
    'error' => 'Qualcosa è andato storto. Riprova tra poco.',
    'unavailable' => 'L\'assistente non è disponibile in questo momento.',
    'throttled' => 'Troppi messaggi in poco tempo: riprova tra un minuto.',
    'spots' => ':count posti liberi',
    'full' => 'Posti esauriti',
    'registered' => 'Sei iscritto',
    'privacy' => 'Le risposte sono generate da un modello AI e possono contenere errori. Non scrivere dati personali.',
];
