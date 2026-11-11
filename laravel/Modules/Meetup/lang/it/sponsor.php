<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Sponsor',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-building-office',
        'sort' => 14,
    ],
    'label' => 'Sponsor',
    'plural_label' => 'Sponsor',
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
    'actions' => [
        'create' => [
            'tooltip' => 'Nuovo',
            'label' => 'Nuovo',
            'icon' => 'create',
        ],
        'logout' => [
            'tooltip' => 'Esci',
            'icon' => 'logout',
            'label' => 'Esci',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'icon' => 'cancel',
            'tooltip' => 'Annulla',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
    ],
];
