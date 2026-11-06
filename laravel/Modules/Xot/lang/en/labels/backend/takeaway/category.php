<?php

declare(strict_types=1);
// Xot translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Xot/docs/wiki — domain i18n only.
// File: lang/en/labels/backend/takeaway/category.php
// Split from labels/backend/takeaway.php

return [
    'management' => 'Category Management',
    'create' => 'Create Category',
    'edit' => 'Edit Category',
    'active' => 'Active Category',
    'view' => 'View Category',
    'tabs' => [
        'titles' => [
            'overview' => 'Overview',
            'history' => 'History',
        ],
        'content' => [
            'overview' => [
                'title' => 'Title',
                'desc' => 'Description',
                'price' => 'Price',
                'dis_price' => 'Discount Price',
                'type' => 'Type',
                'expiry' => 'expiry',
                'created_at' => 'Created At',
                'last_updated' => 'last_updated',
                'deleted_at' => 'deleted_at',
            ],
        ],
    ],
    'table' => [
        'id' => 'Id',
        'resturant_id' => 'Resturant Id',
        'cat_name' => 'Cat Name',
        'cat_desc' => 'Cat Desc',
        'status' => 'Status',
        'cat_image' => 'Cat Image',
        'dish_item' => 'Dish Product',
        'created_at' => 'Created At',
    ],
];
