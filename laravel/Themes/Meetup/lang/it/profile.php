<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Profilo',
        'plural_label' => 'Profili',
        'group' => 'Utenti',
        'icon' => 'heroicon-o-user',
        'sort' => 1,
    ],
    'label' => 'Profilo',
    'plural_label' => 'Profili',
    'badges' => [
        'public_profile' => [
            'label' => 'Profilo pubblico',
        ],
    ],
    'sections' => [
        'profile_details' => [
            'label' => 'Dettagli profilo',
        ],
    ],
    'fields' => [
        'member_since' => [
            'label' => 'Membro dal',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'locale' => [
            'label' => 'Lingua',
        ],
        'location' => [
            'label' => 'Posizione',
        ],
    ],
    'actions' => [
        'browse_events' => [
            'label' => 'Scopri gli eventi',
        ],
        'contact' => [
            'label' => 'Contatta',
        ],
    ],
    'messages' => [
        'anonymous_user' => [
            'label' => 'Utente della community',
        ],
        'short_bio_fallback' => [
            'label' => 'Biografia pubblica non ancora disponibile.',
        ],
    ],
];
