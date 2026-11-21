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
        'total' => ['label' => 'Eventi', 'description' => 'Tutti quelli creati'],
        'upcoming' => ['label' => 'In arrivo', 'description' => 'Da oggi in poi'],
        'registrations' => ['label' => 'Iscrizioni attive', 'description' => 'Posti prenotati negli eventi'],
    ],
];
