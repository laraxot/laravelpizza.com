<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'message',
    ],
    'navigation' => [
        'name' => 'Message',
        'plural' => 'Messages',
        'group' => [
            'name' => 'Admin',
            'description' => 'Administration and configuration',
        ],
        'sort' => 80,
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'label' => 'Messages',
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
        'asset_type' => 'Type',
        'area' => 'Area',
        'parent' => 'Parent asset',
        'name' => 'Name',
        'id' => [
            'label' => 'ID',
        ],
        'parent_id' => [
            'label' => 'Parent ID',
            'placeholder' => 'parent_id',
            'helper_text' => 'parent_id',
            'description' => 'parent_id',
        ],
        'type' => [
            'label' => 'Message Type',
            'placeholder' => 'Select message type',
            'tooltip' => 'Message category',
            'helper_text' => 'Select the message type from the existing list or create a new type using the + button',
            'help' => 'The type is used to categorize and filter messages in the system',
            'description' => 'type',
        ],
        'title' => [
            'label' => 'Title',
            'description' => 'title',
            'helper_text' => 'title',
            'placeholder' => 'title',
        ],
        'valutatore_id' => [
            'label' => 'Valutatore Id',
        ],
        'stabi' => [
            'label' => 'Stabi',
        ],
        'repar' => [
            'label' => 'Repar',
        ],
        'anno' => [
            'label' => 'Year',
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
        ],
        'matr' => [
            'label' => 'Matr',
        ],
        'txt' => [
            'description' => 'txt',
            'helper_text' => 'txt',
            'placeholder' => 'txt',
            'label' => 'txt',
        ],
        'new_type' => [
            'description' => 'new_type',
            'label' => 'new_type',
            'placeholder' => 'new_type',
            'helper_text' => 'new_type',
        ],
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
                'asset_type' => 'Type',
                'parent_inventory_number' => 'Parent inventory code',
            ],
        ],
        'create_type' => [
            'label' => 'Create New Type',
            'tooltip' => 'Add a new message type',
            'modal' => [
                'heading' => 'Create New Message Type',
                'description' => 'Enter the name of the new message type. It will automatically be converted to slug format.',
                'confirm' => 'Create Type',
                'cancel' => 'Cancel',
            ],
            'fields' => [
                'new_type' => [
                    'label' => 'Type Name',
                    'placeholder' => 'e.g. Important Notification',
                    'tooltip' => 'Name of the new message type',
                    'helper_text' => 'Enter the type name. It will automatically be converted to slug format (e.g. "important_notification")',
                    'help' => 'The name will be converted to slug format for database storage',
                ],
            ],
            'messages' => [
                'success' => 'New type created successfully',
                'error' => 'Error creating type',
            ],
        ],
        'logout' => [
            'tooltip' => 'logout',
        ],
    ],
    'widgets' => [
        'child_assets' => 'Child assets',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Mandatory data not present|{2} 2 Mandatory data not present|{3} 3 Mandatory data not present|[4,*] Several mandatory data not present',
    ],
];
