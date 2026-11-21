<?php

declare(strict_types=1);

// Riepilogo in cima all'elenco eventi (Filament\Widgets\EventStatsOverviewWidget)
return [
    // Sezione senza titolo: stringa vuota, altrimenti l'auto-label mostra "empty" sopra le statistiche.
    'sections' => [
        'empty' => [
            'label' => '',
            'heading' => '',
        ],
    ],
    'stats' => [
        'total' => ['label' => 'Events', 'description' => 'All created'],
        'upcoming' => ['label' => 'Upcoming', 'description' => 'From today on'],
        'registrations' => ['label' => 'Active registrations', 'description' => 'Seats booked across events'],
    ],
];
