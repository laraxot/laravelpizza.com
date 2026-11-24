<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio Telegram',
        'plural' => 'Invio Telegram',
    ],
    'navigation' => [
        'name' => 'Invio Telegram',
        'plural' => 'Invio Telegram',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Send messages through Telegram',
        ],
        'label' => 'Invio Telegram',
        'icon' => 'notify-telegram-animated',
        'sort' => '50',
    ],
    'fields' => [
        'chat_id' => [
            'label' => 'ID Chat',
            'placeholder' => 'Enter the chat ID',
            'helper_text' => 'Destination Telegram chat ID',
            'description' => 'Unique Telegram chat identifier',
            'tooltip' => '',
        ],
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Enter the message to send',
            'helper_text' => 'Telegram message content',
            'description' => 'Message text to send via Telegram',
            'tooltip' => '',
        ],
        'parse_mode' => [
            'label' => 'Formato',
            'placeholder' => 'Select the format',
            'helper_text' => 'Message parsing format',
            'description' => 'Message formatting mode',
            'options' => [
                'text' => 'Plain text',
                'html' => 'HTML',
                'markdown' => 'Markdown',
            ],
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Send Message',
            'tooltip' => 'Send a message via Telegram',
            'success_message' => 'Message sent successfully',
            'error_message' => 'Error sending the message',
            'success' => 'Message sent successfully',
            'error' => 'Error while sending the message',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Show a message preview',
            'success_message' => 'Anteprima generata',
            'error_message' => 'Error generating the preview',
        ],
    ],
    'messages' => [
        'success' => 'Telegram message sent successfully',
        'error' => 'An error occurred while sending the Telegram message',
        'confirmation' => 'Are you sure you want to send this Telegram message?',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'sections' => [
        'page' => [
            'title' => 'Telegram Sending Test',
            'description' => 'Use this form to test sending Telegram messages through different providers.',
        ],
    ],
];
