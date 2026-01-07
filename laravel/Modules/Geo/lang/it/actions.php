<?php

declare(strict_types=1);

return [
    'update_coordinates' => [
        'errors' => [
            'empty_address' => 'Indirizzo vuoto non può essere geocodato',
            'geocoding_failed' => 'Impossibile ottenere le coordinate dall\'indirizzo',
        ],
        'bulk' => [
            'label' => 'Aggiorna coordinate',
            'errors' => [
                'generic' => 'Errore durante l\'aggiornamento delle coordinate',
                'record' => 'Errore per :name: :error',
            ],
            'notifications' => [
                'success' => [
                    'title' => 'Coordinate aggiornate',
                    'body' => 'Aggiornate le coordinate di :count record su :total',
                ],
                'warning' => [
                    'title' => 'Alcuni aggiornamenti non sono riusciti',
                    'more_errors' => '... e altri :count errori',
                ],
            ],
        ],
    ],
];
