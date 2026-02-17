<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name.placeholder' => [
            'label' => 'Inserisci il nome del provider',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name.helper_text' => [
            'label' => 'Il nome del provider social (es. Facebook, Google]',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'scopes' => [
            'label' => 'Ambiti',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'scopes.placeholder' => [
            'label' => 'Inserisci gli ambiti di accesso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'scopes.helper_text' => [
            'label' => 'Gli ambiti di accesso richiesti dal provider',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'parameters' => [
            'label' => 'Parametri',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'parameters.placeholder' => [
            'label' => 'Inserisci i parametri aggiuntivi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'parameters.helper_text' => [
            'label' => 'Parametri aggiuntivi per la configurazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'stateless' => [
            'label' => 'Senza stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'stateless.helper_text' => [
            'label' => 'Se il provider non mantiene lo stato della sessione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'active' => [
            'label' => 'Attivo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'active.helper_text' => [
            'label' => 'Se il provider è attualmente attivo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'socialite' => [
            'label' => 'Socialite',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'socialite.helper_text' => [
            'label' => 'Se il provider usa Laravel Socialite',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'svg' => [
            'label' => 'SVG',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'svg.placeholder' => [
            'label' => 'Inserisci il codice SVG dell\'icona',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'svg.helper_text' => [
            'label' => 'L\'icona SVG del provider social',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'name' => 'Social Providers',
        'plural' => 'Social Providers',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Social Providers',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Social Providers',
    'plural_label' => 'Social Providers (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Social Providers',
        ],
        'edit' => [
            'label' => 'Modifica Social Providers',
        ],
        'delete' => [
            'label' => 'Elimina Social Providers',
        ],
    ],
];
