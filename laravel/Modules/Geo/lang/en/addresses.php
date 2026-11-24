<?php

declare(strict_types=1);

return [
    'field' => [
        'label' => 'Indirizzi',
        'help' => [
            'title' => 'Address management',
            'description' => 'You can add multiple addresses. With multiple addresses you can specify an identifying name and designate one as the primary address.',
            'primary_note' => 'Only one address can be set as primary at a time.',
        ],
        'actions' => [
            'add' => 'Add Address',
            'remove' => 'Remove Address',
            'move_up' => 'Move Up',
            'move_down' => 'Move Down',
        ],
        'empty_state' => [
            'title' => 'No address configured',
            'description' => 'Start by adding the first address.',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Address Name',
            'placeholder' => 'es. Sede Principale, Filiale Nord, Casa',
            'help' => 'Identifying name for this address (visible only with multiple addresses)',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_primary' => [
            'label' => 'Primary Address',
            'help' => 'Set this as the primary address (only one can be primary)',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'messages' => [
        'validation' => [
            'min_items' => 'At least :min address(es) required.',
            'max_items' => 'You cannot have more than :max addresses.',
            'primary_required' => 'At least one address must be set as primary.',
        ],
        'success' => [
            'added' => 'Address added successfully.',
            'updated' => 'Addresses updated successfully.',
            'removed' => 'Address removed successfully.',
            'primary_set' => 'Primary address updated.',
        ],
    ],
    'tooltips' => [
        'name_visibility' => 'The name field is visible only when you have more than one address',
        'primary_exclusivity' => 'Setting this as primary will make all others secondary',
        'single_primary' => 'With a single address, it is automatically the primary one',
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
