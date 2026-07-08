<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Messages',
        'plural' => 'Messages',
        'group' => [
            'name' => 'Communications',
            'description' => 'Message and communication management',
        ],
        'label' => 'Messages',
        'sort' => 60,
        'icon' => 'heroicon-o-envelope',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Unique message identifier',
            'tooltip' => 'Message ID',
            'helper_text' => '',
        ],
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'Enter subject',
            'help' => 'Message subject',
            'tooltip' => 'Subject',
            'helper_text' => '',
        ],
        'body' => [
            'label' => 'Content',
            'placeholder' => 'Enter content',
            'help' => 'Message body',
            'tooltip' => 'Message text',
            'helper_text' => '',
        ],
        'from' => [
            'label' => 'From',
            'placeholder' => 'Enter sender',
            'help' => 'Message sender',
            'tooltip' => 'From',
            'helper_text' => '',
        ],
        'to' => [
            'label' => 'To',
            'placeholder' => 'Enter recipient',
            'help' => 'Message recipient',
            'tooltip' => 'To',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Select status',
            'help' => 'Message status',
            'tooltip' => 'Status',
            'helper_text' => '',
            'options' => [
                'draft' => 'Draft',
                'sent' => 'Sent',
                'delivered' => 'Delivered',
                'read' => 'Read',
                'failed' => 'Failed',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New Message',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Create new message',
            'success' => 'Message created successfully',
            'error' => 'Error creating message',
        ],
        'send' => [
            'label' => 'Send',
            'icon' => 'heroicon-o-paper-airplane',
            'tooltip' => 'Send message',
            'success' => 'Message sent successfully',
            'error' => 'Error sending message',
        ],
    ],
    'model' => [
        'label' => 'Message',
        'plural' => 'Messages',
        'description' => 'Message and communication management',
    ],
];
