<?php

declare(strict_types=1);

// Pagine di errore (laravel/resources/views/errors/*, Themes/Meetup/resources/views/errors/page.blade.php)
return [
    '403' => [
        'title' => 'Accesso non consentito',
        'message' => 'Questa pagina non è disponibile per il tuo account.',
    ],
    '404' => [
        'title' => 'Pagina non trovata',
        'message' => 'La pagina che cerchi non esiste o è stata spostata. Magari l\'evento è già passato?',
    ],
    '419' => [
        'title' => 'Sessione scaduta',
        'message' => 'La pagina è rimasta aperta troppo a lungo. Ricaricala e riprova.',
    ],
    '429' => [
        'title' => 'Troppe richieste',
        'message' => 'Hai fatto molte richieste in poco tempo. Aspetta un minuto e riprova.',
    ],
    '500' => [
        'title' => 'Qualcosa è andato storto',
        'message' => 'Abbiamo un problema tecnico. Riprova tra qualche minuto.',
    ],
    '503' => [
        'title' => 'Torniamo subito',
        'message' => 'Stiamo aggiornando il sito. Riprova tra qualche minuto.',
    ],
    'label' => 'Errore',
    'actions' => [
        'home' => 'Torna alla home',
        'events' => 'Guarda i prossimi eventi',
        'reload' => 'Ricarica la pagina',
        'login' => 'Accedi',
    ],
];
