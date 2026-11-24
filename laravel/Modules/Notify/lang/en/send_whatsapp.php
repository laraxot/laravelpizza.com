<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio WhatsApp',
        'plural' => 'Invio WhatsApp',
    ],
    'navigation' => [
        'name' => 'Invio WhatsApp',
        'plural' => 'Invio WhatsApp',
        'group' => [
            'name' => 'Notifications',
            'description' => 'Manage sending WhatsApp notifications',
        ],
        'label' => 'Invio WhatsApp',
        'icon' => 'heroicon-o-paper-airplane',
        'sort' => '20',
    ],
    'fields' => [
        'to' => [
            'label' => 'Recipient',
            'placeholder' => 'Enter the number',
            'helper_text' => 'Recipient phone number',
            'tooltip' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Write the message',
            'helper_text' => 'WhatsApp message content',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Send',
            'tooltip' => 'Send a WhatsApp message to the recipient',
            'success_message' => 'WhatsApp message sent successfully',
            'error_message' => 'Error sending the WhatsApp message',
        ],
    ],
    'messages' => [
        'success' => 'WhatsApp message sent successfully',
        'error' => 'An error occurred while sending the WhatsApp message',
        'confirmation' => 'Are you sure you want to send this WhatsApp message?',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'sections' => [
        'page' => [
            'title' => 'WhatsApp Sending Test',
            'description' => 'Use this form to test sending WhatsApp messages through different providers.',
        ],
    ],
];
