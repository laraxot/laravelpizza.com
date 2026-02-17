<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Exportation',
        'group' => 'Exportations',
        'icon' => 'heroicon-o-arrow-down-tray',
        'sort' => 25,
    ],
    'label' => 'Exportation',
    'plural_label' => 'Exportations',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => 'ID du travail',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exportable_type' => [
            'label' => 'Type exportable',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'file_path' => [
            'label' => 'Chemin du fichier',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'format' => [
            'label' => 'Format',
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
            'label' => 'Créé le',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Complété le',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'export' => [
            'label' => 'Exporter',
        ],
        'download' => [
            'label' => 'Télécharger',
        ],
    ],
];
