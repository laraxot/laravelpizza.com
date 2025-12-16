<?php

declare(strict_types=1);

return [
    'calendar' => [
        'title' => 'Calendario',
        'description' => 'Gestisci i tuoi appuntamenti',
        'types' => [
            'patient' => 'Calendario Paziente',
            'doctor' => 'Calendario Medico',
            'admin' => 'Calendario Amministratore',
        ],
        'events' => [
            'title' => 'Appuntamento',
            'start' => 'Inizio',
            'end' => 'Fine',
            'patient' => 'Paziente',
            'doctor' => 'Medico',
            'status' => 'Stato',
            'type' => 'Tipo',
        ],
        'actions' => [
            'create' => 'Nuovo Appuntamento',
            'edit' => 'Modifica Appuntamento',
            'delete' => 'Elimina Appuntamento',
            'view' => 'Visualizza Dettagli',
        ],
        'messages' => [
            'created' => 'Appuntamento creato con successo',
            'updated' => 'Appuntamento aggiornato con successo',
            'deleted' => 'Appuntamento eliminato con successo',
        ],
    ],
    'buttons' => [
        'today' => 'Oggi',
        'month' => 'Mese',
        'week' => 'Settimana',
        'day' => 'Giorno',
    ],
    'labels' => [
        'all_day' => 'Tutto il giorno',
        'no_events' => 'Nessun evento',
    ],
    'errors' => [
        'load_failed' => 'Impossibile caricare gli eventi',
        'save_failed' => 'Impossibile salvare l\'evento',
        'delete_failed' => 'Impossibile eliminare l\'evento',
    ],
    'success' => [
        'event_created' => 'Evento creato con successo',
        'event_updated' => 'Evento aggiornato con successo',
        'event_deleted' => 'Evento eliminato con successo',
    ],
];
