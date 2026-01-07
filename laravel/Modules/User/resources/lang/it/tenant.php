<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome del tenant',
            'helper_text' => 'Inserisci il nome del tenant',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Slug del tenant',
            'helper_text' => 'Lo slug verrà generato automaticamente dal nome',
        ],
        'domain' => [
            'label' => 'Dominio',
            'placeholder' => 'dominio',
            'helper_text' => 'Il dominio del tenant',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'email@example.com',
            'helper_text' => 'Indirizzo email del tenant',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Telefono',
            'helper_text' => 'Numero di telefono del tenant',
        ],
        'mobile' => [
            'label' => 'Cellulare',
            'placeholder' => 'Cellulare',
            'helper_text' => 'Numero di cellulare del tenant',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Indirizzo',
            'helper_text' => 'Indirizzo del tenant',
        ],
        'primary_color' => [
            'label' => 'primary_color',
            'helper_text' => 'Colore primario del tenant',
        ],
        'secondary_color' => [
            'label' => 'Colore Secondario',
            'helper_text' => 'Colore secondario del tenant',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Tenant',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica Tenant',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Elimina Tenant',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
        ],
        'logout' => [
            'tooltip' => 'logout',
        ],
        'detach' => [
            'tooltip' => 'detach',
        ],
    ],
];
