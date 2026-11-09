<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Events',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-calendar',
        'sort' => 11,
    ],
    'label' => 'Event',
    'plural_label' => 'Events',
    'fields' => [
        'title' => [
            'label' => 'Title',
            'placeholder' => 'E.g. Laravel 13 and Filament 5: what changes',
            'helper_text' => 'The event name, as attendees will see it.',
            'description' => '',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Topics, audience, what to bring…',
            'helper_text' => 'Free text shown on the event page.',
            'description' => '',
            'tooltip' => '',
        ],
        'start_date' => [
            'label' => 'Starts',
            'placeholder' => '',
            'helper_text' => 'Start date and time.',
            'description' => '',
            'tooltip' => '',
        ],
        'end_date' => [
            'label' => 'Ends',
            'placeholder' => '',
            'helper_text' => 'End date and time.',
            'description' => '',
            'tooltip' => '',
        ],
        'location' => [
            'label' => 'City or place',
            'placeholder' => 'E.g. Milan',
            'helper_text' => 'Shown on the event card.',
            'description' => '',
            'tooltip' => '',
        ],
        'status' => [
            'label' => 'Publication',
            'placeholder' => '',
            'helper_text' => 'Only "Published" events are visible on the site.',
            'description' => '',
            'tooltip' => '',
        ],
        'event_status' => [
            'label' => 'Event status',
            'placeholder' => '',
            'helper_text' => 'Scheduled, postponed, cancelled…',
            'description' => '',
            'tooltip' => '',
        ],
        'event_attendance_mode' => [
            'label' => 'Attendance mode',
            'placeholder' => '',
            'helper_text' => 'In person, online or mixed.',
            'description' => '',
            'tooltip' => '',
        ],
        'attendees_count' => [
            'label' => 'Registered',
            'placeholder' => '',
            'helper_text' => 'Calculated automatically: cannot be edited by hand.',
            'description' => '',
            'tooltip' => '',
        ],
        'max_attendees' => [
            'label' => 'Available seats',
            'placeholder' => 'E.g. 60',
            'helper_text' => 'Maximum number of attendees. Required, at least 1.',
            'description' => '',
            'tooltip' => '',
        ],
        'cover_image' => [
            'label' => 'Cover image',
            'placeholder' => '',
            'helper_text' => 'Optional: shown at the top of the event page.',
            'description' => '',
            'tooltip' => '',
        ],
        'in_language' => [
            'label' => 'Language',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'created_at' => [
            'label' => 'Created at',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
    ],
    'delete_confirmation' => [
        'with_attendees' => 'This event has :count active registrations that will be lost. Do you want to delete it?',
        'without_attendees' => 'This event has no registrations. Do you want to delete it?',
    ],
    'sections' => [
        'Event Details' => [
            'label' => 'Event details',
            'heading' => 'Event details',
        ],
    ],
];
