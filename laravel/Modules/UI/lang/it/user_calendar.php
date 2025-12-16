<?php

declare(strict_types=1);

return [
    'months' => [
        'long' => [
            'Gennaio',
            'Febbraio',
            'Marzo',
            'Aprile',
            'Maggio',
            'Giugno',
            'Luglio',
            'Agosto',
            'Settembre',
            'Ottobre',
            'Novembre',
            'Dicembre',
        ],
        'short' => [
            'Gen',
            'Feb',
            'Mar',
            'Apr',
            'Mag',
            'Giu',
            'Lug',
            'Ago',
            'Set',
            'Ott',
            'Nov',
            'Dic',
        ],
    ],
    'weekdays' => [
        'long' => [
            'Domenica',
            'Lunedì',
            'Martedì',
            'Mercoledì',
            'Giovedì',
            'Venerdì',
            'Sabato',
        ],
        'short' => ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'],
        'min' => ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
    ],
    'buttons' => [
        'previous' => 'Mese precedente',
        'next' => 'Mese successivo',
        'today' => 'Oggi',
        'cancel' => 'Annulla',
        'save' => 'Salva',
        'close' => 'Chiudi',
    ],
    'labels' => [
        'today' => 'Oggi',
        'all_day' => 'Tutto il giorno',
        'no_events' => 'Nessun evento programmato',
        'loading' => 'Caricamento in corso...',
    ],
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci un titolo',
            'helper_text' => 'Inserisci un titolo descrittivo',
            'description' => 'Titolo dell\'evento',
        ],
        'starts_at' => [
            'label' => 'Inizio',
            'placeholder' => 'Seleziona data e ora di inizio',
            'helper_text' => 'Data e ora di inizio dell\'evento',
            'description' => 'Data e ora di inizio',
        ],
        'ends_at' => [
            'label' => 'Fine',
            'placeholder' => 'Seleziona data e ora di fine',
            'helper_text' => 'Data e ora di fine dell\'evento',
            'description' => 'Data e ora di fine',
        ],
    ],
    'actions' => [
        'delete' => [
            'label' => 'Elimina',
            'confirm' => 'Sei sicuro di voler eliminare questo evento?',
            'success' => 'Evento eliminato con successo',
            'error' => 'Errore durante l\'eliminazione dell\'evento',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Modifiche salvate con successo',
            'error' => 'Errore durante il salvataggio delle modifiche',
        ],
        'create' => [
            'label' => 'Nuovo evento',
            'success' => 'Evento creato con successo',
            'error' => 'Errore durante la creazione dell\'evento',
        ],
    ],
    'validation' => [
        'required' => 'Questo campo è obbligatorio',
        'date' => 'Inserisci una data valida',
        'after' => 'La data di fine deve essere successiva alla data di inizio',
    ],
];
