<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Statut de la tâche',
        'group' => 'Tâches',
        'icon' => 'heroicon-o-status-online',
        'sort' => 45,
    ],
    'label' => 'Statut de la tâche',
    'plural_label' => 'Statuts de la tâche',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'description' => [
            'label' => 'Description',
        ],
        'color' => [
            'label' => 'Couleur',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
        'updated_at' => [
            'label' => 'Mis à jour le',
        ],
    ],
    'actions' => [
        'update_status' => [
            'label' => 'Mettre à jour le statut',
        ],
        'assign_to_job' => [
            'label' => 'Assigner à la tâche',
        ],
    ],
];