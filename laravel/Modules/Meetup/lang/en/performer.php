<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Speakers',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-microphone',
        'sort' => 13,
    ],
    'label' => 'Speaker',
    'plural_label' => 'Speakers',
    'fields' => [
        'name' => [
            'label' => 'Full name',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'type' => [
            'label' => 'Role',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
            'options' => [
                'speaker' => 'Speaker',
                'host' => 'Host',
                'moderator' => 'Moderator',
            ],
        ],
        'company' => [
            'label' => 'Company',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => '',
            'helper_text' => 'Visible to organizers only.',
            'description' => '',
            'tooltip' => '',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'https://',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'github' => [
            'label' => 'GitHub',
            'placeholder' => 'username',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'linkedin' => [
            'label' => 'LinkedIn',
            'placeholder' => 'https://linkedin.com/in/…',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'twitter' => [
            'label' => 'X / Twitter',
            'placeholder' => 'username',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'bio' => [
            'label' => 'Bio',
            'placeholder' => '',
            'helper_text' => 'Two or three lines about who they are and their talk.',
            'description' => '',
            'tooltip' => '',
        ],
        'events_count' => [
            'label' => 'Events',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
];
