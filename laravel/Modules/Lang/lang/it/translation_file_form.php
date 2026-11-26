<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome del file',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'key' => [
            'label' => 'Chiave',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'content' => [
            'navigation' => [
                'label' => [
                    'label' => 'content.navigation.label',
                ],
                'group' => [
                    'label' => 'content.navigation.group',
                ],
                'icon' => [
                    'label' => 'content.navigation.icon',
                ],
                'sort' => [
                    'label' => 'content.navigation.sort',
                ],
            ],
            'title' => [
                'label' => 'content.title',
            ],
            'fields' => [
                'default_locale' => [
                    'label' => [
                        'label' => 'content.fields.default_locale.label',
                    ],
                    'placeholder' => [
                        'label' => 'content.fields.default_locale.placeholder',
                    ],
                    'helper_text' => [
                        'label' => 'content.fields.default_locale.helper_text',
                    ],
                    'tooltip' => [
                        'label' => 'content.fields.default_locale.tooltip',
                    ],
                    'description' => [
                        'label' => 'content.fields.default_locale.description',
                    ],
                ],
                'supported_locales' => [
                    'label' => [
                        'label' => 'content.fields.supported_locales.label',
                    ],
                    'placeholder' => [
                        'label' => 'content.fields.supported_locales.placeholder',
                    ],
                    'helper_text' => [
                        'label' => 'content.fields.supported_locales.helper_text',
                    ],
                    'tooltip' => [
                        'label' => 'content.fields.supported_locales.tooltip',
                    ],
                    'description' => [
                        'label' => 'content.fields.supported_locales.description',
                    ],
                ],
            ],
            'actions' => [
                'save' => [
                    'label' => [
                        'label' => 'content.actions.save.label',
                    ],
                    'icon' => [
                        'label' => 'content.actions.save.icon',
                    ],
                    'tooltip' => [
                        'label' => 'content.actions.save.tooltip',
                    ],
                ],
                'profile' => [
                    'label' => [
                        'label' => 'content.actions.profile.label',
                    ],
                    'icon' => [
                        'label' => 'content.actions.profile.icon',
                    ],
                    'tooltip' => [
                        'label' => 'content.actions.profile.tooltip',
                    ],
                ],
                'logout' => [
                    'label' => [
                        'label' => 'content.actions.logout.label',
                    ],
                    'icon' => [
                        'label' => 'content.actions.logout.icon',
                    ],
                    'tooltip' => [
                        'label' => 'content.actions.logout.tooltip',
                    ],
                ],
            ],
        ],
    ],
    'sections' => [
        'empty' => [
            'label' => '',
            'heading' => '',
        ],
        'content' => [
            'label' => 'Testi',
            'heading' => 'Testi',
        ],
    ],
];
