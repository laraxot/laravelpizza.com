<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    ],
    'navigation' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
        'group' => [
            'name' => 'Notifications',
            'description' => 'Manage sending SMS notifications',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => '15',
    ],
    'fields' => [
        'driver' => [
            'description' => 'Driver SMS',
            'helper_text' => 'Select the provider used to send SMS',
            'placeholder' => 'Seleziona un driver',
            'label' => 'Driver',
            'tooltip' => '',
        ],
        'message' => [
            'description' => 'Message content',
            'helper_text' => 'Message text to send',
            'placeholder' => 'Write the message',
            'label' => 'Message',
            'tooltip' => '',
        ],
        'phone' => [
            'description' => 'Phone number',
            'helper_text' => 'Recipient number',
            'placeholder' => 'Enter the number',
            'label' => 'Numero telefono',
            'tooltip' => '',
        ],
        'gateway' => [
            'description' => 'Gateway SMS',
            'helper_text' => 'Gateway used for sending',
            'placeholder' => 'Gateway SMS',
            'label' => 'Gateway',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Send SMS',
            'tooltip' => 'Send an SMS message to the recipient',
            'success_message' => 'SMS sent successfully',
            'error_message' => 'Error sending the SMS',
        ],
        'test' => [
            'label' => 'Test connessione',
            'tooltip' => 'Check the connection with the provider',
            'success_message' => 'Connection verified successfully',
            'error_message' => 'Error verifying the connection',
        ],
    ],
    'messages' => [
        'success' => 'SMS sent successfully',
        'error' => 'An error occurred while sending the SMS',
        'confirmation' => 'Are you sure you want to send this SMS?',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'sections' => [
        'page' => [
            'title' => 'SMS Sending Test',
            'description' => 'Use this form to test sending SMS messages through different providers.',
        ],
    ],
];
