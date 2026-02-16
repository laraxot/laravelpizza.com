<?php

declare(strict_types=1);

return [
    'fields' => [
        'provider' => [
            'label' => 'provider',
        ],
        'provider_id' => [
            'label' => 'provider_id',
        ],
        'name' => [
            'label' => 'name',
        ],
        'email' => [
            'label' => 'email',
        ],
        'avatar' => [
            'label' => 'avatar',
        ],
    ],
    'navigation' => [
        'name' => 'Socialite Users',
        'plural' => 'Socialite Users',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Socialite Users',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Socialite Users',
    'plural_label' => 'Socialite Users (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Socialite Users',
        ],
        'edit' => [
            'label' => 'Modifica Socialite Users',
        ],
        'delete' => [
            'label' => 'Elimina Socialite Users',
        ],
    ],
];
