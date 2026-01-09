<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Emploi Échoué',
        'group' => 'Emplois Échoués',
        'icon' => 'heroicon-o-exclamation-triangle',
        'sort' => 27,
    ],
    'label' => 'Emploi Échoué',
    'plural_label' => 'Emplois Échoués',
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
        'exception' => [
            'label' => 'Exception',
        ],
        'failed_at' => [
            'label' => 'Échoué À',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => 'Réessayer',
        ],
        'delete' => [
            'label' => 'Supprimer',
        ],
        'retry_all' => [
            'label' => 'Réessayer Tous',
        ],
        'delete_all' => [
            'label' => 'Supprimer Tous',
        ],
    ],
];
