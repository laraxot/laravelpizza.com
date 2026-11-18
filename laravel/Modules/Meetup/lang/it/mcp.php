<?php

declare(strict_types=1);

// Messaggi dei tool del server MCP (Modules\Meetup\Mcp): li legge l'agente e spesso li ripete all'utente.
return [
    'messages' => [
        'registered' => 'Iscrizione a ":title" confermata. Abbiamo inviato l\'email di riepilogo con il file per il calendario.',
        'already_registered' => 'Sei già iscritto a ":title".',
        'unregistered' => 'Iscrizione a ":title" annullata: il posto torna disponibile.',
    ],
    'errors' => [
        'unauthenticated' => 'Serve un utente: collega il client con un token personale di Laravel Pizza Meetups.',
        'not_found' => 'Nessun evento pubblicato con slug ":slug". Usa search_events per trovare lo slug.',
        'full' => '":title" è al completo: non ci sono più posti.',
        'started' => '":title" è già iniziato: le iscrizioni sono chiuse.',
        'not_registered' => 'Non risulti iscritto a ":title".',
        'closed' => 'Le iscrizioni a ":title" non sono aperte.',
    ],
];
