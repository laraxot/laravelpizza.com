<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'name' => ['label' => 'name', 'placeholder' => 'name', 'helper_text' => 'name', 'description' => 'name'],
        'created_at' => ['label' => 'created_at'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'associate' => ['label' => 'associate', 'icon' => 'associate', 'tooltip' => 'associate'],
        'edit' => ['label' => 'edit', 'icon' => 'edit', 'tooltip' => 'edit'],
        'dissociate' => ['label' => 'dissociate', 'icon' => 'dissociate', 'tooltip' => 'dissociate'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
    ],
    'label' => 'Permessi del ruolo',
    'navigation' => ['label' => 'Permessi ruolo', 'icon' => 'Permessi ruolo', 'sort' => 86],
];
