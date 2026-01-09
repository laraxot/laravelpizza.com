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
        ],
        'connection' => [
            'label' => 'Connexion',
        ],
        'queue' => [
            'label' => 'File d\'attente',
        ],
        'payload' => [
            'label' => 'Charge Utile',
        ],
        'attempts' => [
            'label' => 'Tentatives',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'display_name' => [
            'label' => 'Nom d\'Affichage',
        ],
        'reserved_at' => [
            'label' => 'Réservé À',
        ],
        'available_at' => [
            'label' => 'Disponible À',
        ],
        'created_at' => [
            'label' => 'Créé À',
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
