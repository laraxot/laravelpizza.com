<?php

declare(strict_types=1);

return [
    'fields' => [
        'recipient' => [
            'label' => 'recipient',
            'placeholder' => 'recipient',
            'helper_text' => 'recipient',
            'description' => 'recipient',
        ],
        'subject' => [
            'helper_text' => 'subject',
            'description' => 'subject',
        ],
        'body_html' => [
            'helper_text' => 'body_html',
            'description' => 'body_html',
        ],
        'template' => [
            'helper_text' => 'template',
            'description' => 'template',
        ],
        'add_attachments' => [
            'helper_text' => 'add_attachments',
            'description' => 'add_attachments',
        ],
    ],
    'actions' => [
        'sendEmail' => [
            'label' => 'sendEmail',
            'icon' => 'sendEmail',
            'tooltip' => 'sendEmail',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
    ],
];
