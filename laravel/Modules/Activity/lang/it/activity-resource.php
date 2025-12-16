<?php
declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Risorse Attività',
        'plural' => 'Risorse Attività',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Gestione delle risorse di attività',
        ],
        'label' => 'Risorse Attività',
        'sort' => 64,
        'icon' => 'activity-resource-animated',
    ],
    'fields' => [
        'resource_type' => [
            'label' => 'Tipo Risorsa',
            'help' => 'Tipo di risorsa attività',
        ],
        'resource_id' => [
            'label' => 'ID Risorsa',
            'help' => 'Identificativo della risorsa',
        ],
        'activity_count' => [
            'label' => 'Numero Attività',
            'help' => 'Numero di attività associate',
        ],
        'last_activity' => [
            'label' => 'Ultima Attività',
            'help' => 'Data e ora dell\'ultima attività',
        ],
    ],
    'actions' => [
        'view_activities' => [
            'label' => 'Visualizza Attività',
            'tooltip' => 'Visualizza tutte le attività della risorsa',
        ],
        'export' => [
            'label' => 'Esporta',
            'tooltip' => 'Esporta dati della risorsa',
        ],
    ],
    'messages' => [
        'no_resources' => 'Nessuna risorsa trovata',
        'resource_exported' => 'Risorsa esportata con successo',
    ],
];
