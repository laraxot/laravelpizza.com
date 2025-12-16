<?php

declare(strict_types=1);

return [
    'sections' => [
        'fields' => [
            'name' => [
                'label' => 'Name',
                'tooltip' => 'Enter the section name',
            ],
            'slug' => [
                'label' => 'Slug',
                'tooltip' => 'Unique section identifier',
            ],
            'image' => [
                'label' => 'Image',
                'tooltip' => 'Select an image for the section',
            ],
            'content' => [
                'label' => 'Content',
                'tooltip' => 'Enter the section content',
            ],
            'status' => [
                'label' => 'Status',
                'tooltip' => 'Select the section status',
                'options' => [
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ],
            ],
        ],
    ],
    'blocks' => [
        'quick_links' => [
            'fields' => [
                'label' => [
                    'label' => 'Label',
                    'tooltip' => 'Enter the quick links label',
                ],
                'links' => [
                    'label' => 'Links',
                    'tooltip' => 'Add quick links',
                    'fields' => [
                        'label' => [
                            'label' => 'Label',
                            'tooltip' => 'Enter the link label',
                        ],
                        'url' => [
                            'label' => 'URL',
                            'tooltip' => 'Enter the link URL',
                        ],
                    ],
                ],
            ],
        ],
        'footer' => [
            'links' => [
                'fields' => [
                    'links' => [
                        'label' => 'Links',
                        'tooltip' => 'Add footer links',
                        'fields' => [
                            'label' => [
                                'label' => 'Label',
                                'tooltip' => 'Enter the link label',
                            ],
                            'url' => [
                                'label' => 'URL',
                                'tooltip' => 'Enter the link URL',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'filament' => [
        'blocks' => [
            'footer' => [
                'links' => [
                    'fields' => [
                        'links' => [
                            'fields' => [
                                'label' => [
                                    'label' => 'Label',
                                    'tooltip' => 'Enter the link label',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
