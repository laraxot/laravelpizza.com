<?php

declare(strict_types=1);

return [
    'fields' => [
        'title' => [
            'label' => 'Titolo',
        ],
        'slug' => [
            'label' => 'Indirizzo (slug)',
        ],
        'description' => [
            'label' => 'Descrizione',
        ],
        'middleware' => [
            'label' => 'Middleware',
        ],
    ],
    'actions' => [
        'delete' => [
            'tooltip' => '',
            'icon' => 'delete',
            'label' => 'Elimina',
        ],
        'edit' => [
            'tooltip' => 'edit',
            'icon' => 'edit',
        ],
    ],
];
