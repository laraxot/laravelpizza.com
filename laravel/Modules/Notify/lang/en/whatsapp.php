<?php

declare(strict_types=1);


return [
    'resource' => [
        'name' => 'WhatsApp',
        'plural' => 'WhatsApp',
    ],
    'navigation' => [
        'name' => 'Send WhatsApp',
        'plural' => 'Send WhatsApp',
        'group' => [
            'name' => 'Notifications',
            'description' => 'WhatsApp notification management',
        ],
        'label' => 'Send WhatsApp',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => '20',
    ],
    'fields' => [
        'to' => [
            'label' => 'Phone Number',
            'placeholder' => 'Enter phone number',
            'helper_text' => 'Enter phone number with international prefix (e.g. +1)',
        ],
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Enter message',
            'helper_text' => 'Message cannot exceed 4096 characters',
        ],
        'driver' => [
            'label' => 'WhatsApp Provider',
            'placeholder' => 'Select WhatsApp provider',
            'helper_text' => 'Select the WhatsApp provider to use',
        ],
        'template' => [
            'label' => 'Template',
            'placeholder' => 'Enter template name',
            'helper_text' => 'Template name (optional)',
        ],
        'parameters' => [
            'label' => 'Parameters',
            'placeholder' => 'Enter parameters',
            'helper_text' => 'Parameters for the template (optional)',
        ],
        'media_url' => [
            'label' => 'Media URL',
            'placeholder' => 'Enter media URL',
            'helper_text' => 'Media URL (optional)',
        ],
        'media_type' => [
            'label' => 'Media Type',
            'placeholder' => 'Select media type',
            'helper_text' => 'Select the media type',
        ],
    ],
    'drivers' => [
        'twilio' => 'Twilio',
        'messagebird' => 'MessageBird',
        'vonage' => 'Vonage',
        'infobip' => 'Infobip',
    ],
    'media_types' => [
        'image' => 'Image',
        'video' => 'Video',
        'document' => 'Document',
        'audio' => 'Audio',
    ],
    'actions' => [
        'send' => 'Send WhatsApp',
        'cancel' => 'Cancel',
    ],
    'messages' => [
        'success' => 'WhatsApp sent successfully',
        'error' => 'An error occurred while sending the WhatsApp',
    ],
];
