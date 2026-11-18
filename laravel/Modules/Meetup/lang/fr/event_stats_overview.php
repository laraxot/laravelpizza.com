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
        'total' => ['label' => 'Événements', 'description' => 'Tous ceux créés'],
        'upcoming' => ['label' => 'À venir', 'description' => 'À partir d\'aujourd\'hui'],
        'registrations' => ['label' => 'Inscriptions actives', 'description' => 'Places réservées'],
    ],
];
