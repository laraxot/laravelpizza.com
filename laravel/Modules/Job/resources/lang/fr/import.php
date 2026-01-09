<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Importation',
        'group' => 'Importations',
        'icon' => 'heroicon-o-arrow-up-tray',
        'sort' => 26,
    ],
    'label' => 'Importation',
    'plural_label' => 'Importations',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'ID de l\'Emploi',
        ],
        'importable_type' => [
            'label' => 'Type Importable',
        ],
        'file_path' => [
            'label' => 'Chemin du Fichier',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'created_at' => [
            'label' => 'Créé À',
        ],
        'completed_at' => [
            'label' => 'Complété À',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importer',
        ],
        'upload' => [
            'label' => 'Télécharger',
        ],
        'create' => [
            'label' => 'Créer',
        ],
    ],
];
