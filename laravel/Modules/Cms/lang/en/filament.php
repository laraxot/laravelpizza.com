<?php

declare(strict_types=1);

return [
    'footer' => [
        'label' => 'Footer',
        'info' => [
            'label' => 'Footer Info',
            'logo' => 'Footer Logo',
        ],
        'links' => [
            'label' => 'Footer Links',
            'links' => [
                'label' => 'Link Label',
                'url' => 'Link URL',
                'icon' => 'Link Icon',
            ],
        ],
        'social' => [
            'label' => 'Footer Social',
            'social_links' => 'Social Links',
        ],
        'contacts' => [
            'label' => 'Footer Contacts',
        ],
        'newsletter' => [
            'label' => 'Footer Newsletter',
        ],
        'quick_links' => [
            'label' => 'Footer Quick Links',
            'links' => [
                'label' => 'Quick Links',
            ],
        ],
    ],
    'resources' => [
        'section' => [
            'label' => 'Section',
            'plural' => 'Sections',
            'navigation' => [
                'label' => 'Sections',
                'icon' => 'heroicon-o-rectangle-stack',
            ],
        ],
    ],
    'blocks' => [
        'footer' => [
            'label' => 'Footer',
            'info' => [
                'label' => 'Footer Info',
                'fields' => [
                    'logo' => 'Footer Logo',
                    'company_name' => 'Company Name',
                    'description' => 'Description',
                    'email' => 'Email',
                    'phone' => 'Phone',
                    'address' => 'Address',
                ],
            ],
            'links' => [
                'label' => 'Link Footer',
                'fields' => [
                    'title' => 'Section Title',
                    'links' => [
                        'label' => 'Link',
                        'fields' => [
                            'label' => 'Etichetta Link',
                            'url' => 'URL',
                            'icon' => 'Icon (optional)',
                        ],
                    ],
                ],
            ],
            'social' => [
                'label' => 'Footer Social',
                'fields' => [
                    'title' => 'Section Title',
                    'social_links' => 'Link Social',
                    'platform' => 'Social Platform',
                    'url' => 'URL Profilo',
                ],
            ],
            'contact' => [
                'label' => 'Footer Contacts',
                'fields' => [
                    'title' => 'Section Title',
                    'address' => 'Address',
                    'phone' => 'Phone',
                    'email' => 'Email',
                ],
            ],
            'newsletter' => [
                'label' => 'Footer Newsletter',
                'fields' => [
                    'title' => 'Section Title',
                    'description' => 'Description',
                    'button_text' => 'Button Text',
                ],
            ],
            'quick_links' => [
                'label' => 'Link Rapidi Footer',
                'fields' => [
                    'title' => 'Title',
                    'links' => [
                        'label' => 'Link Rapidi',
                        'fields' => [
                            'label' => 'Label',
                            'url' => 'URL',
                            'target' => 'Target',
                        ],
                    ],
                ],
            ],
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
