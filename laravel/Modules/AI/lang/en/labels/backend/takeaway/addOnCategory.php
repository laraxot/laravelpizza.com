<?php

declare(strict_types=1);
// Xot translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Xot/docs/wiki — domain i18n only.
// File: lang/en/labels/backend/takeaway/addOnCategory.php
// Split from labels/backend/takeaway.php

return [
    'table' => [
        'id' => 'ID',
        'addon_cat_item_name' => 'AddOn Category Name',
        'addon_cat_desc' => 'AddOn Category Description',
        'status' => 'Status',
        'created_at' => 'Created At',
    ],
    'management' => 'AddOn Category Managment',
    'create' => 'Create AddOn Category ',
    'edit' => 'Edit AddOn Category',
    'active' => 'Active AddOn Category',
    'view' => 'View',
    'tabs' => [
        'content' => [
            'overview' => [
                'name' => 'Name',
                'desc' => 'Description',
                'status' => 'Status',
                'created_at' => 'Created At',
                'last_updated' => 'Last Updated',
                'deleted_at' => 'Deleted At',
            ],
        ],
        'titles' => [
            'overview' => 'Overview',
            'history' => 'History',
        ],
    ],
];
