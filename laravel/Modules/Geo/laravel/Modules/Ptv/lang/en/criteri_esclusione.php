<?php

declare(strict_types=1);

return [
    'types' => [
        'string' => 'String',
        'int' => 'Integer',
        'date' => 'Date',
        'list' => 'List',
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter name',
            'help' => 'Identification name of the criteria',
        ],
        'field_name' => [
            'label' => 'Field name',
            'placeholder' => 'Enter field name',
            'help' => 'Name of the field to evaluate',
            'description' => 'field_name',
        ],
        'op' => [
            'label' => 'Operator',
            'placeholder' => 'Select operator',
            'help' => 'Comparison operator',
            'options' => [
                '=' => 'Equal to',
                '!=' => 'Not equal to',
                '>' => 'Greater than',
                '<' => 'Less than',
                '>=' => 'Greater or equal to',
                '<=' => 'Less or equal to',
                'LIKE' => 'Contains',
                'NOT LIKE' => 'Does not contain',
            ],
            'description' => 'op',
            'helper_text' => 'op',
        ],
        'value' => [
            'label' => 'Value',
            'placeholder' => 'Enter value',
            'help' => 'Reference value for comparison',
            'description' => 'value',
            'helper_text' => 'value',
        ],
        'type' => [
            'label' => 'Type',
            'placeholder' => 'Select type',
            'help' => 'Data type to compare',
            'description' => 'type',
            'helper_text' => 'type',
        ],
        'anno' => [
            'label' => 'Year',
            'placeholder' => 'Enter year',
            'help' => 'Reference year',
            'description' => 'anno',
            'helper_text' => 'anno',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Create exclusion criteria',
            'success' => 'Exclusion criteria created successfully',
            'error' => 'An error occurred while creating the exclusion criteria',
        ],
        'edit' => [
            'label' => 'Edit exclusion criteria',
            'success' => 'Exclusion criteria updated successfully',
            'error' => 'An error occurred while updating the exclusion criteria',
        ],
        'delete' => [
            'label' => 'Delete exclusion criteria',
            'success' => 'Exclusion criteria deleted successfully',
            'error' => 'An error occurred while deleting the exclusion criteria',
            'confirm' => 'Are you sure you want to delete this exclusion criteria?',
        ],
    ],
    'description' => 'Management of exclusion criteria for cards',
    'navigation' => [
        'name' => 'Exclusion Criteria',
        'plural' => 'Exclusion Criteria',
        'sort' => 96,
        'icon' => 'heroicon-o-x-circle',
        'group' => 'Configuration',
        'label' => 'Exclusion Criteria',
    ],
];
