<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Planification',
        'group' => 'Outils',
        'icon' => 'heroicon-o-calendar',
        'sort' => 31,
    ],
    'label' => 'Planification',
    'plural_label' => 'Planifications',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'command' => [
            'label' => 'Commande',
        ],
        'expression' => [
            'label' => 'Expression Cron',
        ],
        'description' => [
            'label' => 'Description',
        ],
        'timezone' => [
            'label' => 'Fuseau horaire',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
        'updated_at' => [
            'label' => 'Mis à jour le',
        ],
    ],
    'actions' => [
        'run' => [
            'label' => 'Exécuter',
        ],
        'enable' => [
            'label' => 'Activer',
        ],
        'disable' => [
            'label' => 'Désactiver',
        ],
    ],
];