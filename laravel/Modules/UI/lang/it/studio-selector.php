<?php

declare(strict_types=1);

return [
    'actions' => [
        'select' => [
            'label' => 'Seleziona',
            'description' => 'Scegli questo studio',
        ],
    ],
    'empty' => [
        'title' => 'Nessuno studio trovato',
        'description' => 'Non ci sono studi disponibili per la zona selezionata.',
    ],
    'fields' => [
        'distance' => [
            'label' => 'Distanza',
            'helper_text' => 'Distanza approssimativa dalla tua posizione',
        ],
        'phone' => [
            'label' => 'Telefono',
            'helper_text' => 'Numero di telefono dello studio',
        ],
        'specializations' => [
            'label' => 'Specializzazioni',
            'helper_text' => 'Servizi offerti dallo studio',
        ],
    ],
    'accessibility' => [
        'studio_card' => 'Scheda studio, clicca per selezionare',
        'selected_studio' => 'Studio selezionato',
        'select_studio' => 'Premi spazio o invio per selezionare questo studio',
    ],
];
