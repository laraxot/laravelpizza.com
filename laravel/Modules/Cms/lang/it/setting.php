<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Impostazioni',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Impostazioni',
    'fields' => [
        'pub_theme' => [
            'label' => 'Tema del sito pubblico',
            'placeholder' => 'Scegli un tema',
            'helper_text' => 'Solo i temi installati in Themes/. Si legge a ogni richiesta, senza config:cache.',
            'tooltip' => '',
            'description' => '',
        ],
        'register_pub_theme' => [
            'label' => 'Registra viste e traduzioni del tema',
            'placeholder' => '',
            'helper_text' => 'Spento: il sito usa le viste dei moduli. Acceso: il tema scelto sovrascrive le viste e carica le sue traduzioni.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Salva',
        ],
        'profile' => [
            'label' => 'Profilo',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profilo',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Esci',
        ],
    ],
];
