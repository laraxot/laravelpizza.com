<?php

declare(strict_types=1);

// Iscritti di un evento (EventResource/RelationManagers/RegistrationsRelationManager) ed export CSV.
return [
    'navigation' => [
        'label' => 'Attendees',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-users',
        'sort' => 15,
    ],
    'label' => 'Registration',
    'plural_label' => 'Attendees',
    'fields' => [
        'user' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => '',
                'helper_text' => '',
                'description' => '',
                'tooltip' => '',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => '',
                'helper_text' => '',
                'description' => '',
                'tooltip' => '',
            ],
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
            'options' => [
                'attending' => 'Registered',
                'cancelled' => 'Cancelled',
            ],
        ],
        'created_at' => [
            'label' => 'Registered at',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'export_csv' => [
            'label' => 'Download CSV',
            'tooltip' => 'Attendee list for Excel',
        ],
        'cancel_registration' => [
            'label' => 'Cancel registration',
            'tooltip' => 'Cancel registration',
            'modal_heading' => 'Cancel this registration?',
            'modal_description' => 'The seat becomes available again. The person is not notified automatically.',
            'notification' => 'Registration cancelled',
        ],
    ],
];
