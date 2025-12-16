<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Dashboard',
        'plural' => 'Dashboard',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Panoramica delle attività',
        ],
        'label' => 'Dashboard',
        'sort' => 59,
        'icon' => 'activity-dashboard-animated',
    ],
    'widgets' => [
        'recent_activities' => 'Attività Recenti',
        'activity_summary' => 'Riepilogo Attività',
        'top_users' => 'Utenti Più Attivi',
        'activity_by_type' => 'Attività per Tipo',
        'system_health' => 'Stato del Sistema',
        'error_logs' => 'Log di Errore',
    ],
    'charts' => [
        'activities_over_time' => 'Attività nel Tempo',
        'activities_by_user' => 'Attività per Utente',
        'activities_by_type' => 'Attività per Tipo',
        'error_distribution' => 'Distribuzione Errori',
    ],
    'metrics' => [
        'total_activities' => 'Totale Attività',
        'unique_users' => 'Utenti Unici',
        'average_actions' => 'Azioni Medie',
        'error_rate' => 'Tasso di Errore',
    ],
    'periods' => [
        'last_hour' => 'Ultima Ora',
        'today' => 'Oggi',
        'yesterday' => 'Ieri',
        'last_7_days' => 'Ultimi 7 giorni',
        'last_30_days' => 'Ultimi 30 giorni',
        'this_month' => 'Questo mese',
        'last_month' => 'Mese scorso',
        'custom' => 'Personalizzato',
    ],
    'status' => [
        'healthy' => 'In Salute',
        'warning' => 'Attenzione',
        'critical' => 'Critico',
    ],
];
