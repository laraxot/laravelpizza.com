<?php

declare(strict_types=1);

return [
    'fields' => [
        'addresses' => [
            'label' => 'Indirizzi',
            'placeholder' => 'Select or enter an address',
            'help' => 'Manage the addresses associated with the record',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Address Name',
            'placeholder' => 'Enter an identifying name',
            'help' => 'Descriptive name to easily identify the address (e.g. Home, Office, Studio)',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_primary' => [
            'label' => 'Primary Address',
            'placeholder' => 'Select whether this is the primary address',
            'help' => 'Indicates whether this is the primary address among all registered ones',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
