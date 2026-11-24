<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'SMS',
        'plural' => 'SMS',
    ],
    'navigation' => [
        'name' => 'Send SMS',
        'plural' => 'Send SMS',
        'group' => [
            'name' => 'Notifications',
            'description' => 'SMS notification management',
        ],
        'label' => 'Send SMS',
        'icon' => 'heroicon-o-device-phone-mobile',
        'sort' => '10',
    ],
    'fields' => [
        'to' => [
            'label' => 'Phone Number',
            'placeholder' => 'Enter phone number',
            'helper_text' => 'Enter phone number with international prefix (e.g. +1)',
            'tooltip' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Enter message',
            'helper_text' => 'Message cannot exceed 160 characters',
            'tooltip' => '',
            'description' => '',
        ],
        'driver' => [
            'label' => 'SMS Provider',
            'placeholder' => 'Select SMS provider',
            'helper_text' => 'Select the SMS provider to use',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'drivers' => [
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        'plivo' => 'Plivo',
        'gammu' => 'Gammu',
        'netfun' => 'Netfun',
    ],
    'actions' => [
        'send' => 'Send SMS',
        'cancel' => 'Cancel',
    ],
    'messages' => [
        'success' => 'SMS sent successfully',
        'error' => 'An error occurred while sending the SMS',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'form' => [
        'to' => [
            'label' => 'Recipient',
            'helper' => 'Number with country code, e.g. +39…',
        ],
        'from' => [
            'label' => 'Sender',
            'helper' => 'Name or number shown to the recipient',
        ],
        'body' => [
            'label' => 'Text',
            'helper' => 'Up to 160 characters per SMS',
        ],
        'provider' => [
            'label' => 'Provider',
        ],
    ],
];
