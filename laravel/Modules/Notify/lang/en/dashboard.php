<?php

declare(strict_types=1);


return [
    'resource' => [
        'name' => 'Dashboard',
        'plural' => 'Dashboard',
    ],
    'navigation' => [
        'name' => 'Dashboard',
        'plural' => 'Dashboard',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Panoramica delle notifiche',
        ],
        'label' => 'Dashboard',
        'sort' => '49',
        'icon' => 'notify-dashboard-animated',
        'description' => 'Panoramica del sistema di notifiche',
    ],
    'widgets' => [
        'total_notifications' => [
            'label' => 'Totale Notifiche',
            'description' => 'Numero totale di notifiche nel sistema',
        ],
        'unread_notifications' => [
            'label' => 'Notifiche Non Lette',
            'description' => 'Numero di notifiche ancora da leggere',
        ],
        'notifications_by_type' => [
            'label' => 'Notifiche per Tipo',
            'description' => 'Distribuzione delle notifiche per tipologia',
        ],
        'recent_notifications' => [
            'label' => 'Notifiche Recenti',
            'description' => 'Elenco delle notifiche più recenti',
        ],
        'notification_trends' => [
            'label' => 'Trend Notifiche',
            'description' => 'Andamento delle notifiche nel tempo',
        ],
        'channel_status' => [
            'label' => 'Stato Canali',
            'description' => 'Stato operativo dei canali di notifica',
        ],
        'top_recipients' => [
            'label' => 'Destinatari Principali',
            'description' => 'Utenti che ricevono più notifiche',
        ],
    ],
    'cards' => [
        'overall_status' => [
            'label' => 'Stato Generale',
            'description' => 'Panoramica dello stato del sistema di notifiche',
        ],
        'channels' => [
            'label' => 'Canali',
            'description' => 'Configurazione dei canali di notifica',
        ],
        'templates' => [
            'label' => 'Template',
            'description' => 'Template disponibili per le notifiche',
        ],
        'logs' => [
            'label' => 'Log',
            'description' => 'Registri delle attività di notifica',
        ],
    ],
    'actions' => [
        'refresh' => [
            'label' => 'Aggiorna',
            'tooltip' => 'Aggiorna i dati della dashboard',
            'success_message' => 'Dashboard aggiornata con successo',
            'error_message' => 'Errore nell\'aggiornamento della dashboard',
        ],
        'export' => [
            'label' => 'Esporta Dati',
            'tooltip' => 'Esporta i dati statistici in formato CSV',
            'success_message' => 'Dati esportati con successo',
            'error_message' => 'Errore nell\'esportazione dei dati',
        ],
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
        'no_data' => 'Nessun dato disponibile per il periodo selezionato',
        'loading' => 'Caricamento dati in corso...',
    ],
];
