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
        'total' => ['label' => 'Eventos', 'description' => 'Todos los creados'],
        'upcoming' => ['label' => 'Próximos', 'description' => 'Desde hoy'],
        'registrations' => ['label' => 'Inscripciones activas', 'description' => 'Plazas reservadas'],
    ],
];
