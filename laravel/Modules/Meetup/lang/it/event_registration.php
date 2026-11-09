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
        'registered' => 'Iscrizione confermata! Ti abbiamo inviato un\'email di riepilogo.',
        'unregistered' => 'Iscrizione annullata.',
        'full' => 'Ci dispiace, l\'evento è al completo.',
        'already_registered' => 'Risulti già iscritto a questo evento.',
        'not_registered' => 'Non risulti iscritto a questo evento.',
        'started' => 'L\'evento è già iniziato: le iscrizioni sono chiuse.',
        'closed' => 'Le iscrizioni per questo evento non sono aperte.',
    ],
    'mail' => [
        'subject' => 'Iscrizione confermata: :title',
        'greeting' => 'Ciao!',
        'intro' => 'La tua iscrizione a ":title" è confermata.',
        'date' => 'Quando: :date',
        'venue' => 'Dove: :venue',
        'action' => 'Vedi l\'evento',
    ],
];
