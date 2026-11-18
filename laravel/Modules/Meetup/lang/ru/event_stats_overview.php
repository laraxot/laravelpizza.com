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
        'total' => ['label' => 'События', 'description' => 'Все созданные'],
        'upcoming' => ['label' => 'Предстоящие', 'description' => 'С сегодняшнего дня'],
        'registrations' => ['label' => 'Активные записи', 'description' => 'Забронированные места'],
    ],
];
