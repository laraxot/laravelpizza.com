<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'SMS',
<<<<<<< HEAD
        'plural' => 'SMS',
    ],
=======
<<<<<<< HEAD
        'plural' => 'SMS',
    ],
=======
        'plural' => 'SMS'],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    'navigation' => [
        'name' => 'Send SMS',
        'plural' => 'Send SMS',
        'group' => [
            'name' => 'Notifications',
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
            'description' => 'SMS notification management',
        ],
        'label' => 'Send SMS',
        'icon' => 'heroicon-o-device-phone-mobile',
        'sort' => '10',
    ],
<<<<<<< HEAD
=======
=======
            'description' => 'SMS notification management'],
        'label' => 'Send SMS',
        'icon' => 'heroicon-o-device-phone-mobile',
        'sort' => '10'],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    'fields' => [
        'to' => [
            'label' => 'Phone Number',
            'placeholder' => 'Enter phone number',
            'helper_text' => 'Enter phone number with international prefix (e.g. +1)',
            'tooltip' => '',
<<<<<<< HEAD
            'description' => '',
        ],
=======
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Enter message',
            'helper_text' => 'Message cannot exceed 160 characters',
            'tooltip' => '',
<<<<<<< HEAD
            'description' => '',
        ],
=======
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
        'driver' => [
            'label' => 'SMS Provider',
            'placeholder' => 'Select SMS provider',
            'helper_text' => 'Select the SMS provider to use',
            'tooltip' => '',
<<<<<<< HEAD
            'description' => '',
        ],
    ],
=======
<<<<<<< HEAD
            'description' => '',
        ],
    ],
=======
            'description' => '']],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
    'drivers' => [
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        'plivo' => 'Plivo',
        'gammu' => 'Gammu',
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
=======
=======
        'netfun' => 'Netfun'],
    'actions' => [
        'send' => 'Send SMS',
        'cancel' => 'Cancel'],
    'messages' => [
        'success' => 'SMS sent successfully',
        'error' => 'An error occurred while sending the SMS'],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label'];
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
