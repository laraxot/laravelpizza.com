<?php

declare(strict_types=1);

return [
    'status' => [
        'all' => [
            'label'       => 'All Events',
            'description' => 'Label for all events filter',
        ],
        'upcoming' => [
            'label'       => 'Upcoming',
            'description' => 'Label for upcoming events',
        ],
        'past' => [
            'label'       => 'Past Events',
            'description' => 'Label for past events',
        ],
    ],

    'fields' => [
        'about_this_event' => [
            'label'       => 'About this event',
            'description' => 'Section title for event description',
        ],
        'event_details' => [
            'label'       => 'Event Details',
            'description' => 'Section title for event information',
        ],
        'date' => [
            'label'       => 'Date',
            'description' => 'Label for event date',
        ],
        'time' => [
            'label'       => 'Time',
            'description' => 'Label for event time',
        ],
        'location' => [
            'label'       => 'Location',
            'description' => 'Label for event location',
        ],
        'language' => [
            'label'       => 'Language',
            'description' => 'Label for event language',
        ],
        'attendees' => [
            'label'       => 'Attendees',
            'description' => 'Label for event attendees',
        ],
        'people_joined' => [
            'label'       => ':count people have joined',
            'description' => 'Message showing number of attendees',
        ],
        'available_spots' => [
            'label'       => ':count spots available',
            'description' => 'Message showing available spots',
        ],
        'spots_filled' => [
            'label'       => 'spots filled',
            'description' => 'Label for attendee count',
        ],
    ],

    'actions' => [
        'back_to_events' => [
            'label'       => 'Back to Events',
            'tooltip'     => 'Return to events list',
            'helper_text' => '',
            'description' => 'Link to return to events list',
            'icon'        => 'heroicon-o-arrow-left',
            'color'       => 'secondary',
        ],
        'register_now' => [
            'label'       => 'Register Now',
            'tooltip'     => 'Reserve your spot',
            'helper_text' => '',
            'description' => 'Call to action button for registration',
            'icon'        => 'heroicon-o-check-circle',
            'color'       => 'primary',
        ],
        'join_event' => [
            'label'       => 'Join this event',
            'tooltip'     => 'Sign up to attend',
            'helper_text' => '',
            'description' => 'Call to action to join event',
            'icon'        => 'heroicon-o-user-plus',
            'color'       => 'primary',
        ],
        'book_your_spot' => [
            'label'       => 'Book your spot now!',
            'tooltip'     => 'Reserve your place',
            'helper_text' => '',
            'description' => 'Call to action to book a spot',
            'icon'        => 'heroicon-o-ticket',
            'color'       => 'primary',
        ],
        'share_event' => [
            'label'       => 'Share this event',
            'tooltip'     => 'Share with friends',
            'helper_text' => '',
            'description' => 'Label for share button',
            'icon'        => 'heroicon-o-share',
            'color'       => 'secondary',
        ],
    ],

    'messages' => [
        'no_events_found' => [
            'label'       => 'No events found',
            'description' => 'Message when no events are available',
        ],
        'check_back_later' => [
            'label'       => 'Check back later',
            'description' => 'Encouragement to check again later',
        ],
        'spots_filling_fast' => [
            'label'       => 'Spots are filling up fast!',
            'description' => 'Urgency message for limited spots',
        ],
        'event_location' => [
            'label'       => 'Event Location',
            'description' => 'Title for event location section',
        ],
        'map_loading' => [
            'label'       => 'Loading map...',
            'description' => 'Message while map is loading',
        ],
        'click_to_view' => [
            'label'       => 'Click to view on Google Maps',
            'description' => 'Instruction to view location on map',
        ],
    ],
];
