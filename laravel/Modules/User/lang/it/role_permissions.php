<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'icon' => 'create',
            'label' => 'create',
            'tooltip' => 'create',
        ],
        'associate' => [
            'icon' => 'associate',
            'label' => 'Collega',
            'tooltip' => 'associate',
        ],
        'edit' => [
            'icon' => 'edit',
            'label' => 'edit',
            'tooltip' => 'edit',
        ],
        'dissociate' => [
            'icon' => 'dissociate',
            'label' => 'Scollega',
            'tooltip' => 'dissociate',
        ],
        'delete' => [
            'icon' => 'delete',
            'label' => 'delete',
            'tooltip' => 'delete',
        ],
    ],
    'label' => 'Permessi del ruolo',
    'navigation' => [
        'label' => 'Permessi ruolo',
        'icon' => 'Permessi ruolo',
        'sort' => 86,
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
    ],
];
