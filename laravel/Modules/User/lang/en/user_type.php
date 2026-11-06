<?php

declare(strict_types=1);

return [
    'fields' => [
        'master_admin' => ['label' => 'Master admin', 'placeholder' => 'Master admin', 'helper_text' => 'Master admin', 'description' => 'Master admin'],
        'backoffice_user' => ['label' => 'Backoffice', 'placeholder' => 'Backoffice', 'helper_text' => 'Backoffice', 'description' => 'Backoffice'],
        'customer_user' => ['label' => 'Customer', 'placeholder' => 'Customer', 'helper_text' => 'Customer', 'description' => 'Customer'],
        'system' => ['label' => 'System', 'placeholder' => 'System', 'helper_text' => 'System', 'description' => 'System'],
        'technician' => ['label' => 'Technician', 'placeholder' => 'Technician', 'helper_text' => 'Technician', 'description' => 'Technician'],
    ],
    'values' => [
        'master_admin' => [
            'label' => 'Master admin',
            'color' => 'danger',
            'icon' => 'heroicon-o-shield-check',
        ],
        'backoffice_user' => [
            'label' => 'Backoffice',
            'color' => 'warning',
            'icon' => 'heroicon-o-briefcase',
        ],
        'customer_user' => [
            'label' => 'Customer',
            'color' => 'success',
            'icon' => 'heroicon-o-user',
        ],
        'system' => [
            'label' => 'System',
            'color' => 'gray',
            'icon' => 'heroicon-o-cog-6-tooth',
        ],
        'technician' => [
            'label' => 'Technician',
            'color' => 'info',
            'icon' => 'heroicon-o-wrench-screwdriver',
        ],
    ],
];
