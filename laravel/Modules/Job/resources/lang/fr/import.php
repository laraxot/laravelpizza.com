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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => 'ID de l\'Emploi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'importable_type' => [
            'label' => 'Type Importable',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'file_path' => [
            'label' => 'Chemin du Fichier',
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
        'created_at' => [
            'label' => 'Créé À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Complété À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
