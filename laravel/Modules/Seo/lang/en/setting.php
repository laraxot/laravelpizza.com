<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Settings',
        'group' => 'Configuration',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Settings',
    'fields' => [
        'path_aliases' => [
            'label' => 'Duplicate pages (aliases)',
            'placeholder' => '',
            'helper_text' => 'One row for each page written under two names: the alias answers with a 301 redirect to the final page, in the same language, and is left out of the sitemap. Removing the row restores the page.',
            'tooltip' => '',
            'description' => '',
        ],
        'alias' => [
            'label' => 'Alias',
            'placeholder' => 'faqs',
            'helper_text' => 'Path without language of the page to retire (e.g. faqs).',
            'tooltip' => '',
            'description' => '',
        ],
        'target' => [
            'label' => 'Final page',
            'placeholder' => 'faq',
            'helper_text' => 'Path without language of the page to keep. Empty = home. Never another alias.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'errors' => [
        'path_aliases' => 'Some rows are not valid: the alias is empty, repeated, points at itself or at another alias. Every alias must point at a final page.',
    ],
    'actions' => [
        'save' => [
            'label' => 'Save',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Save',
        ],
        'profile' => [
            'label' => 'Profile',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profile',
        ],
        'logout' => [
            'label' => 'Log out',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Log out',
        ],
    ],
];
