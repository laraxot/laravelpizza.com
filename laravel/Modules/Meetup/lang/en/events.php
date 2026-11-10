<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Events',
        'plural_label' => 'Events',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-calendar',
        'sort' => 11,
    ],
    'label' => 'Events',
    'plural_label' => 'Events',
    'fields' => [
        'title' => [
            'label' => 'Title',
        ],
        'start_date' => [
            'label' => 'Start',
        ],
        'end_date' => [
            'label' => 'End',
        ],
        'location' => [
            'label' => 'City',
        ],
        'venue' => [
            'name' => [
                'label' => 'Venue',
            ],
        ],
        'status' => [
            'label' => 'Publication',
        ],
        'event_status' => [
            'label' => 'Status',
        ],
        'event_attendance_mode' => [
            'label' => 'Mode',
        ],
        'attendees_count' => [
            'label' => 'Attendees',
        ],
        'max_attendees' => [
            'label' => 'Seats',
        ],
        'in_language' => [
            'label' => 'Language',
        ],
        'created_at' => [
            'label' => 'Created at',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New',
            'tooltip' => 'New',
        ],
        'edit' => [
            'label' => 'Edit',
            'tooltip' => 'Edit',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete',
        ],
        'view' => [
            'label' => 'Open',
            'tooltip' => 'Open',
        ],
        'layout' => [
            'label' => 'Change view',
            'tooltip' => 'Change view (table or cards)',
        ],
    ],
    'no_events_found' => [
        'label' => 'No events found',
        'description' => 'There are no events matching your search criteria',
    ],
    'check_back_later' => [
        'label' => 'Check back soon',
        'description' => 'New events will be available soon',
    ],
];
