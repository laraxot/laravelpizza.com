<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Dashboard Geo',
        'plural' => 'Dashboard Geo',
        'group' => [
            'name' => 'Geo',
            'description' => 'Panoramica delle informazioni geografiche',
        ],
        'label' => 'Dashboard',
        'sort' => 30,
        'icon' => 'ui-dashboard', // Aggiornamento dell'icona della dashboard usando la nuova icona dashboard
    ],
    'widgets' => [
        'total_locations' => 'Totale Località',
        'total_places' => 'Totale Luoghi',
        'recent_activity' => 'Attività Recente',
        'popular_places' => 'Luoghi Popolari',
    ],
    'charts' => [
        'locations_by_type' => 'Località per Tipo',
        'places_by_category' => 'Luoghi per Categoria',
        'activity_timeline' => 'Timeline Attività',
    ],
];
