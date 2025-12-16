<?php

declare(strict_types=1);

return [
    'months' => [
        'long' => [
            '0' => 'Gennaio',
            '1' => 'Febbraio',
            '2' => 'Marzo',
            '3' => 'Aprile',
            '4' => 'Maggio',
            '5' => 'Giugno',
            '6' => 'Luglio',
            '7' => 'Agosto',
            '8' => 'Settembre',
            '9' => 'Ottobre',
            '10' => 'Novembre',
            '11' => 'Dicembre',
        ],
        'short' => [
            '0' => 'Gen',
            '1' => 'Feb',
            '2' => 'Mar',
            '3' => 'Apr',
            '4' => 'Mag',
            '5' => 'Giu',
            '6' => 'Lug',
            '7' => 'Ago',
            '8' => 'Set',
            '9' => 'Ott',
            '10' => 'Nov',
            '11' => 'Dic',
        ],
    ],
    'weekdays' => [
        'long' => [
            '0' => 'Domenica',
            '1' => 'Lunedì',
            '2' => 'Martedì',
            '3' => 'Mercoledì',
            '4' => 'Giovedì',
            '5' => 'Venerdì',
            '6' => 'Sabato',
        ],
        'short' => [
            '0' => 'Dom',
            '1' => 'Lun',
            '2' => 'Mar',
            '3' => 'Mer',
            '4' => 'Gio',
            '5' => 'Ven',
            '6' => 'Sab',
        ],
        'min' => [
            '0' => 'Do',
            '1' => 'Lu',
            '2' => 'Ma',
            '3' => 'Me',
            '4' => 'Gi',
            '5' => 'Ve',
            '6' => 'Sa',
        ],
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
