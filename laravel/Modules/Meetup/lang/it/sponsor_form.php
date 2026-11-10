<?php

declare(strict_types=1);

// Etichette del form (SponsorResource/Schemas/SponsorForm, usato anche dal form evento).
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'level' => [
            'label' => 'Livello',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
            'options' => [
                'platinum' => 'Platinum',
                'gold' => 'Gold',
                'silver' => 'Silver',
                'bronze' => 'Bronze',
                'community' => 'Community',
            ],
        ],
        'website' => [
            'label' => 'Sito web',
            'placeholder' => 'https://',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'logo' => [
            'label' => 'Logo (URL)',
            'placeholder' => 'https://',
            'helper_text' => 'Indirizzo di un\'immagine del logo.',
            'description' => '',
            'tooltip' => '',
        ],
        'contact_name' => [
            'label' => 'Referente',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'contact_email' => [
            'label' => 'Email del referente',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'order' => [
            'label' => 'Ordine',
            'placeholder' => '',
            'helper_text' => 'I numeri più bassi vengono mostrati per primi.',
            'description' => '',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'events_count' => [
            'label' => 'Eventi',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
];
