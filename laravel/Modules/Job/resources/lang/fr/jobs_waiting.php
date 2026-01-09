<?php

declare(strict_types=1);

return [
    'fields' => [
        'status' => [
            'label' => 'Statut',
        ],
        'display_name' => [
            'label' => 'Nom d\'Affichage',
        ],
        'queue' => [
            'label' => 'File d\'attente',
        ],
        'attempts' => [
            'label' => 'Tentatives',
        ],
        'reserved_at' => [
            'label' => 'Réservé À',
        ],
        'created_at' => [
            'label' => 'Créé À',
        ],
    ],
    'navigation' => [
        'sort' => 91,
        'icon' => 'heroicon-o-clock',
        'group' => 'Système',
        'label' => 'Emplois en Attente',
    ],
];

];