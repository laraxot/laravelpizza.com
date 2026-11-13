<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Utente Tenant',
        'plural' => 'Utenti Tenant',
        'label' => 'Utenti Tenant',
        'group' => [
            'name' => 'Tenants',
            'description' => 'Gestione degli utenti associati ai tenant',
        ],
        'sort' => 87,
        'icon' => 'heroicon-o-building-office',
    ],
    'label' => 'Tenant User',
    'plural_label' => 'Tenant User (Plurale)',
    'fields' => [
        'edit' => [
            'label' => 'Modifica Tenant User',
        ],
        'delete' => [
            'label' => 'Elimina Tenant User',
            'icon' => 'delete',
        ],
        'resetColumnManager' => [
            'icon' => 'resetColumnManager',
        ],
        'createAnother' => [
            'icon' => 'createAnother',
        ],
        'save' => [
            'icon' => 'save',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
        ],
    ],
];
