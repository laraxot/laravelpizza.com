<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Rating Morph',
    ],
    'navigation' => [
        'name' => 'Rating Morph',
        'plural' => 'Rating Morph',
        'group' => [
            'name' => 'Admin',
            'description' => 'Administrative management',
        ],
        'label' => 'Rating Morph',
        'sort' => 92,
        'icon' => 'heroicon-o-chart-bar',
    ],
    'fields' => [
        'brand' => 'Brand',
        'model' => 'Model',
        'description' => 'Description',
        'serial_number' => 'Serial number',
        'inventory_number' => 'Inventory code',
        'code' => 'Identifier',
        'manufacturing_year' => 'Manufacturing year',
        'purchase_year' => 'Purchase year',
        'is_enabled' => 'Is active?',
        'asset_type' => 'Asset type',
        'area' => 'Area',
        'parent' => 'Parent asset',
        'name' => 'Name',
    ],
    'actions' => [
        'enable' => [
            'cta' => 'Enable',
        ],
        'disable' => [
            'cta' => 'Disable',
        ],
        'import' => [
            'row_number' => 'Row :row',
            'fields' => [
                'import_file' => 'Select an XLS or CSV file to upload',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Asset list as of',
            'columns' => [
                'brand' => 'Brand',
                'model' => 'Model',
                'description' => 'Description',
                'serial_number' => 'Serial number',
                'inventory_number' => 'Inventory code',
                'code' => 'Identifier',
                'manufacturing_year' => 'Manufacturing year',
                'purchase_year' => 'Purchase year',
                'is_enabled' => 'Is active?',
                'asset_type' => 'Asset type',
                'parent_inventory_number' => 'Parent inventory code',
            ],
        ],
    ],
    'widgets' => [
        'child_assets' => 'Child assets',
    ],
    'exceptions' => [
        'not_found' => 'Rating morph not found',
        'unauthorized' => 'You are not authorized to perform this action',
    ],
];
