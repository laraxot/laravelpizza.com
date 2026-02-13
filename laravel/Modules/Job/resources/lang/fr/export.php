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
        ],
        'job_id' => [
            'label' => 'ID du travail',
        ],
        'exportable_type' => [
            'label' => 'Type exportable',
        ],
        'file_path' => [
            'label' => 'Chemin du fichier',
        ],
        'format' => [
            'label' => 'Format',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
        'completed_at' => [
            'label' => 'Complété le',
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
