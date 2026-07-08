<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Facility Managers',
        'plural' => 'Facility Managers',
        'group' => [
            'name' => 'Admin',
            'description' => 'Facility and manager administration',
        ],
        'label' => 'Facility Managers',
        'sort' => 43,
        'icon' => 'heroicon-o-building-office',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Unique identifier',
            'tooltip' => 'Record ID',
            'helper_text' => '',
        ],
        'valutatore_id' => [
            'label' => 'Evaluator',
            'placeholder' => 'Select evaluator',
            'help' => 'User performing evaluation',
            'tooltip' => 'Evaluator ID',
            'helper_text' => '',
        ],
        'stabi' => [
            'label' => 'Facility',
            'placeholder' => 'Select facility',
            'help' => 'Facility code',
            'tooltip' => 'Facility',
            'helper_text' => '',
        ],
        'repar' => [
            'label' => 'Department',
            'placeholder' => 'Select department',
            'help' => 'Department code',
            'tooltip' => 'Department',
            'helper_text' => '',
        ],
        'anno' => [
            'label' => 'Year',
            'placeholder' => 'Enter year',
            'help' => 'Reference year',
            'tooltip' => 'Fiscal year',
            'helper_text' => '',
        ],
        'matr' => [
            'label' => 'Employee Number',
            'placeholder' => 'Enter employee number',
            'help' => 'Manager employee number',
            'tooltip' => 'Employee ID',
            'helper_text' => '',
        ],
        'cognome' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter last name',
            'help' => 'Manager last name',
            'tooltip' => 'Surname',
            'helper_text' => '',
        ],
        'nome' => [
            'label' => 'First Name',
            'placeholder' => 'Enter first name',
            'help' => 'Manager first name',
            'tooltip' => 'Name',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Create New',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Create new record',
            'success' => 'Record created successfully',
            'error' => 'Error creating record',
        ],
        'edit' => [
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'tooltip' => 'Edit record',
            'success' => 'Record updated successfully',
            'error' => 'Error updating record',
        ],
        'delete' => [
            'label' => 'Delete',
            'icon' => 'heroicon-o-trash',
            'tooltip' => 'Delete record',
            'confirmation' => 'Are you sure you want to delete this record?',
            'success' => 'Record deleted successfully',
            'error' => 'Error deleting record',
        ],
    ],
    'model' => [
        'label' => 'Facility Manager',
        'plural' => 'Facility Managers',
        'description' => 'Facility and manager management',
    ],
];
