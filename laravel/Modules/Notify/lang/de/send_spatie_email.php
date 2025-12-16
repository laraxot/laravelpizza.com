<?php

declare(strict_types=1);


return [
    'navigation' => [
        'label' => 'Invio Email (Spatie)',
        'group' => 'Notifiche',
    ],
    'actions' => [
        'emailFormActions' => [
            'label' => 'emailFormActions',
        ],
    ],
    'fields' => [
        'body_html' => [
            'description' => 'body_html',
            'helper_text' => 'body_html',
            'placeholder' => 'body_html',
            'label' => 'body_html',
        ],
        'subject' => [
            'description' => 'subject',
            'helper_text' => 'subject',
            'placeholder' => 'subject',
            'label' => 'subject',
        ],
        'to' => [
            'description' => 'to',
            'helper_text' => 'to',
            'placeholder' => 'to',
            'label' => 'to',
        ],
        'mail_templates' => [
            'description' => 'mail_templates',
            'helper_text' => 'mail_templates',
            'placeholder' => 'mail_templates',
        ],
        'mail_template_slug' => [
            'description' => 'mail_template_slug',
            'helper_text' => 'mail_template_slug',
            'placeholder' => 'mail_template_slug',
            'label' => 'mail_template_slug',
        ],
    ],
];
