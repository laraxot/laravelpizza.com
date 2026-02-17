<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Emplois en Attente',
        'group' => 'Emplois',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Emploi en Attente',
    'plural_label' => 'Emplois en Attente',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Connexion',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'File d\'attente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Charge Utile',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'attempts' => [
            'label' => 'Tentatives',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Statut',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'display_name' => [
            'label' => 'Nom d\'Affichage',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reserved_at' => [
            'label' => 'Réservé À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'available_at' => [
            'label' => 'Disponible À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Créé À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'process' => [
            'label' => 'Traiter',
        ],
        'retry' => [
            'label' => 'Réessayer',
        ],
    ],
];
