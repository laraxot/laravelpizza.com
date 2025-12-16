<?php

declare(strict_types=1);

return [
    'months' => [
        'long' => [
            '0' => 'January',
            '1' => 'February',
            '2' => 'March',
            '3' => 'April',
            '4' => 'May',
            '5' => 'June',
            '6' => 'July',
            '7' => 'August',
            '8' => 'September',
            '9' => 'October',
            '10' => 'November',
            '11' => 'December',
        ],
        'short' => [
            '0' => 'Jan',
            '1' => 'Feb',
            '2' => 'Mar',
            '3' => 'Apr',
            '4' => 'May',
            '5' => 'Jun',
            '6' => 'Jul',
            '7' => 'Aug',
            '8' => 'Sep',
            '9' => 'Oct',
            '10' => 'Nov',
            '11' => 'Dec',
        ],
    ],
    'weekdays' => [
        'long' => [
            '0' => 'Sunday',
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday',
        ],
        'short' => [
            '0' => 'Sun',
            '1' => 'Mon',
            '2' => 'Tue',
            '3' => 'Wed',
            '4' => 'Thu',
            '5' => 'Fri',
            '6' => 'Sat',
        ],
        'min' => [
            '0' => 'Su',
            '1' => 'Mo',
            '2' => 'Tu',
            '3' => 'We',
            '4' => 'Th',
            '5' => 'Fr',
            '6' => 'Sa',
        ],
    ],
    'buttons' => [
        'previous' => 'Previous month',
        'next' => 'Next month',
        'today' => 'Today',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'close' => 'Close',
    ],
    'labels' => [
        'today' => 'Today',
        'all_day' => 'All day',
        'no_events' => 'No scheduled events',
        'loading' => 'Loading...',
    ],
    'fields' => [
        'title' => [
            'label' => 'Title',
            'placeholder' => 'Enter a title',
            'helper_text' => 'Enter a descriptive title',
            'description' => 'Event title',
        ],
        'starts_at' => [
            'label' => 'Start',
            'placeholder' => 'Select start date and time',
            'helper_text' => 'Event start date and time',
            'description' => 'Start date and time',
        ],
        'ends_at' => [
            'label' => 'End',
            'placeholder' => 'Select end date and time',
            'helper_text' => 'Event end date and time',
            'description' => 'End date and time',
        ],
    ],
    'actions' => [
        'delete' => [
            'label' => 'Delete',
            'confirm' => 'Are you sure you want to delete this event?',
            'success' => 'Event deleted successfully',
            'error' => 'Error deleting event',
        ],
        'edit' => [
            'label' => 'Edit',
            'success' => 'Changes saved successfully',
            'error' => 'Error saving changes',
        ],
        'create' => [
            'label' => 'New event',
            'success' => 'Event created successfully',
            'error' => 'Error creating event',
        ],
    ],
    'validation' => [
        'required' => 'This field is required',
        'date' => 'Enter a valid date',
        'after' => 'End date must be after start date',
    ],
];
