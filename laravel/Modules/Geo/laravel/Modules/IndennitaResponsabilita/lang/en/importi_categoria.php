<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Category Amounts',
        'group' => 'Allowance',
        'icon' => 'heroicon-o-currency-euro',
        'sort' => 100,
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Unique identifier',
        ],
        'ente' => [
            'label' => 'Entity',
            'placeholder' => 'Entity code',
            'help' => 'Entity identification code',
        ],
        'categoria' => [
            'label' => 'Category',
            'placeholder' => 'Category code',
            'help' => 'Economic category reference',
        ],
        'lista_propro' => [
            'label' => 'Professional Profile List',
            'placeholder' => 'Profile list (e.g: 1,2,3)',
            'help' => 'Comma-separated professional profile codes',
        ],
        'anno' => [
            'label' => 'Year',
            'placeholder' => 'Reference year',
            'help' => 'Year of validity for amounts',
        ],
        'min' => [
            'label' => 'Minimum Amount',
            'placeholder' => '0.00',
            'help' => 'Minimum amount for the category',
        ],
        'max' => [
            'label' => 'Maximum Amount',
            'placeholder' => '0.00',
            'help' => 'Maximum amount for the category',
        ],
        'created_at' => [
            'label' => 'Created at',
            'help' => 'Record creation date',
        ],
        'updated_at' => [
            'label' => 'Updated at',
            'help' => 'Last modification date',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Category Amount',
            'modal' => [
                'heading' => 'Create New Category Amount',
                'description' => 'Enter data to create a new amount range',
            ],
            'success' => 'Category amount created successfully',
            'error' => 'Error creating category amount',
        ],
        'edit' => [
            'label' => 'Edit',
            'modal' => [
                'heading' => 'Edit Category Amount',
                'description' => 'Update category amount data',
            ],
            'success' => 'Category amount updated successfully',
            'error' => 'Error updating category amount',
        ],
        'delete' => [
            'label' => 'Delete',
            'modal' => [
                'heading' => 'Delete Category Amount',
                'description' => 'Are you sure you want to delete this category amount?',
            ],
            'confirmation' => 'This action is irreversible. Confirm deletion?',
            'success' => 'Category amount deleted successfully',
            'error' => 'Error deleting category amount',
        ],
        'view' => [
            'label' => 'View',
        ],
    ],

    'messages' => [
        'empty_state' => 'No category amounts found',
        'validation_error' => 'Validation errors detected',
        'saved' => 'Category amount saved successfully',
    ],
];
