<?php

declare(strict_types=1);

return [
    'instructions' => [
        'title' => 'Opening Hours Configuration',
        'description' => 'Set opening hours for each day of the week. Leave empty for closed days.',
    ],
    'headers' => [
        'day' => 'Day',
        'morning' => 'Morning',
        'afternoon' => 'Afternoon',
    ],
    'legend' => [
        'open' => 'Open',
        'closed' => 'Closed',
        'format' => 'Format: HH:MM',
    ],
    'days' => [
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
        'sunday' => 'Sunday',
    ],
    'periods' => [
        'morning' => 'Morning',
        'afternoon' => 'Afternoon',
        'evening' => 'Evening',
    ],
    'labels' => [
        'morning' => 'Morning',
        'afternoon' => 'Afternoon',
        'from' => 'From',
        'to' => 'To',
        'closed' => 'Closed',
    ],
    'descriptions' => [
        'day_schedule' => 'Configure opening hours for this day',
    ],
    'placeholders' => [
        'morning_hours' => 'Morning hours',
        'afternoon_hours' => 'Afternoon hours',
    ],
    'notes' => [
        'format_hint' => 'Use 24-hour format (e.g. 14:30 for 2:30 PM)',
        'empty_hint' => 'Leave empty means "closed"',
    ],
    'validation' => [
        'invalid_format' => 'Invalid time format. Use HH:MM-HH:MM',
        'invalid_time_range' => 'Opening time must be before closing time',
        'overlapping_hours' => 'Hours cannot overlap on the same day',
        'from_before_to' => 'The "From" time must be before the "To" time',
        'to_after_from' => 'The "To" time must be after the "From" time',
        'time_sequence' => 'Start time must be before end time',
        'morning_before_afternoon' => 'For :day, morning closing time must be before afternoon opening time.',
        'missing_closing_time' => 'If you specify :session opening time for :day, you must also specify closing time.',
        'missing_opening_time' => 'If you specify :session closing time for :day, you must also specify opening time.',
        'opening_before_closing' => 'The :session opening time for :day must be before closing time.',
        'morning' => 'morning',
        'afternoon' => 'afternoon',
        'opening_hours' => [
            'morning_before_afternoon' => 'For :day, morning closing time must be before afternoon opening time.',
            'missing_closing_time' => 'If you specify :session opening time for :day, you must also specify closing time.',
            'missing_opening_time' => 'If you specify :session closing time for :day, you must also specify opening time.',
            'opening_before_closing' => 'The :session opening time for :day must be before closing time.',
            'morning' => 'morning',
            'afternoon' => 'afternoon',
        ],
    ],
];
