<?php

declare(strict_types=1);

return [
    'column.name' => 'Nome',
    'column.guard_name' => 'Nome Guard',
    'column.roles' => 'Ruoli',
    'column.permissions' => 'Permessi',
    'column.updated_at' => 'Aggiornato a',
    'field.name' => 'Nome',
    'field.guard_name' => 'Nome Guard',
    'field.permissions' => 'Permessi',
    'field.select_all.name' => 'Seleziona Tutto',
    'field.select_all.message' => 'Abilita tutti i Permessi attualmente <span class="text-primary font-medium">Abilitati</span> per questo ruolo',
    'nav.group' => 'Filament Shield',
    'nav.role.label' => 'Ruoli',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Ruolo',
    'resource.label.roles' => 'Ruoli',
    'section' => 'Entities',
    'resources' => 'Resources',
    'widgets' => 'Widgets',
    'pages' => 'Pages',
    'custom' => 'Permessi Personalizzati',
    'forbidden' => 'Non hai i permessi di accesso',
    'navigation' => [
        'name' => 'Filament Shield',
        'plural' => 'Filament Shield',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Filament Shield',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Filament Shield',
    'plural_label' => 'Filament Shield (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Filament Shield',
        ],
        'edit' => [
            'label' => 'Modifica Filament Shield',
        ],
        'delete' => [
            'label' => 'Elimina Filament Shield',
        ],
    ],
];
