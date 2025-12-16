<?php

declare(strict_types=1);


return [
    'template' => [
        'navigation' => [
            'group' => 'Notifications',
            'label' => 'Email Templates',
            'plural' => 'Email Templates',
            'singular' => 'Email Template',
            'icon' => 'heroicon-o-envelope',
            'sort' => '1',
        ],
        'sections' => [
            'main' => 'Main Information',
        ],
        'fields' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Enter template name',
                'tooltip' => 'The identifying name of the email template',
            ],
            'layout' => [
                'label' => 'Layout',
                'placeholder' => 'Select template layout',
                'tooltip' => 'The graphical layout that will be used for the email',
            ],
            'mailable' => [
                'label' => 'Mailable Class',
                'placeholder' => 'Enter the Mailable class name',
                'tooltip' => 'The PHP class that handles email sending',
            ],
            'subject' => [
                'label' => 'Subject',
                'placeholder' => 'Enter the email subject',
                'tooltip' => 'The subject that will appear in the email',
            ],
            'body_html' => [
                'label' => 'HTML Content',
                'placeholder' => 'Enter the email HTML content',
                'tooltip' => 'The email content in HTML format',
            ],
            'body_text' => [
                'label' => 'Text Content',
                'placeholder' => 'Enter the email text content',
                'tooltip' => 'Text version of the email for clients that don\'t support HTML',
            ],
        ],
        'actions' => [
            'preview' => [
                'label' => 'Preview',
                'tooltip' => 'View a preview of the template',
            ],
        ],
        'messages' => [
            'created' => 'Email template created successfully',
            'updated' => 'Email template updated successfully',
            'deleted' => 'Email template deleted successfully',
        ],
    ],
];
