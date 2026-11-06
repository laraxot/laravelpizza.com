<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Utente Tenant',
        'plural' => 'Utenti Tenant',
        'label' => 'Utenti Tenant',
        'group' => ['name' => 'Tenants', 'description' => 'Gestione degli utenti associati ai tenant'],
        'sort' => 87,
        'icon' => 'heroicon-o-building-office',
    ],
    'label' => 'Tenant User',
    'plural_label' => 'Tenant User (Plurale)',
    'fields' => [
        'edit' => ['label' => 'Modifica Tenant User'],
        'delete' => ['label' => 'Elimina Tenant User', 'icon' => 'delete', 'tooltip' => 'delete'],
        'resetColumnManager' => ['tooltip' => 'resetColumnManager', 'label' => 'resetColumnManager', 'icon' => 'resetColumnManager'],
        'createAnother' => ['label' => 'createAnother', 'icon' => 'createAnother', 'tooltip' => 'createAnother'],
        'save' => ['label' => 'save', 'icon' => 'save', 'tooltip' => 'save'],
        'applyFilters' => ['label' => 'applyFilters', 'icon' => 'applyFilters', 'tooltip' => 'applyFilters'],
        'openFilters' => ['label' => 'openFilters', 'icon' => 'openFilters', 'tooltip' => 'openFilters'],
        'resetFilters' => ['label' => 'resetFilters', 'icon' => 'resetFilters', 'tooltip' => 'resetFilters'],
        'applyTableColumnManager' => ['label' => 'applyTableColumnManager', 'icon' => 'applyTableColumnManager', 'tooltip' => 'applyTableColumnManager'],
        'openColumnManager' => ['label' => 'openColumnManager', 'icon' => 'openColumnManager', 'tooltip' => 'openColumnManager'],
    ],
];
