<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => [
            'label' => 'Navigation Name',
            'placeholder' => 'Enter navigation name',
            'helper_text' => 'Name of the navigation item',
            'description' => 'Navigation item name',
        ],
        'plural' => [
            'label' => 'Navigation Plural',
            'placeholder' => 'Enter plural form',
            'helper_text' => 'Plural form of navigation name',
            'description' => 'Navigation plural form',
        ],
        'group' => [
            'name' => [
                'label' => 'Group Name',
                'placeholder' => 'Enter group name',
                'helper_text' => 'Name of the navigation group',
                'description' => 'Navigation group name',
            ],
            'description' => [
                'label' => 'Group Description',
                'placeholder' => 'Enter group description',
                'helper_text' => 'Description of the navigation group',
                'description' => 'Navigation group description',
            ],
            'label' => 'Navigation Group',
            'placeholder' => 'Select navigation group',
            'helper_text' => 'Group for organizing navigation items',
        ],
        'label' => [
            'label' => 'Navigation Label',
            'placeholder' => 'Enter navigation label',
            'helper_text' => 'Label displayed in navigation',
            'description' => 'Navigation item label',
        ],
        'sort' => [
            'label' => 'Navigation Sort',
            'placeholder' => 'Enter sort order',
            'helper_text' => 'Sort order in navigation menu',
            'description' => 'Navigation sort order',
        ],
        'icon' => [
            'label' => 'Navigation Icon',
            'placeholder' => 'Enter icon name',
            'helper_text' => 'Icon for navigation item',
            'description' => 'Navigation item icon',
        ],
        'color' => [
            'label' => 'Navigation Color',
            'placeholder' => 'Select color',
            'helper_text' => 'Color for navigation item',
            'description' => 'Navigation item color',
        ],
        'tooltip' => [
            'label' => 'Navigation Tooltip',
            'placeholder' => 'Enter tooltip text',
            'helper_text' => 'Tooltip for navigation item',
            'description' => 'Navigation item tooltip',
        ],
    ],
    'fields' => [
        'level' => [
            'label' => [
                'label' => 'Level Label',
                'placeholder' => 'Enter level label',
                'helper_text' => 'Label for the level',
                'description' => 'Level label description',
            ],
            'emergency' => [
                'label' => 'Emergency Level',
                'placeholder' => 'Enter emergency level',
                'helper_text' => 'Emergency level setting',
                'description' => 'Emergency level description',
            ],
            'alert' => [
                'label' => 'Alert Level',
                'placeholder' => 'Enter alert level',
                'helper_text' => 'Alert level setting',
                'description' => 'Alert level description',
            ],
            'critical' => [
                'label' => 'Critical Level',
                'placeholder' => 'Enter critical level',
                'helper_text' => 'Critical level setting',
                'description' => 'Critical level description',
            ],
        ],
    ],
    'resources' => [
        'doctor' => [
            'navigation' => [
                'group' => 'Doctor Management',
            ],
        ],
    ],
];
