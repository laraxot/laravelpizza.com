<?php

declare(strict_types=1);

return [
    'opening_hours' => [
        'morning' => 'morning',
        'afternoon' => 'afternoon',
        'morning_before_afternoon' => 'For :day, morning closing time must be before afternoon opening time.',
        'missing_closing_time' => 'If you specify :session opening time for :day, you must also specify closing time.',
        'missing_opening_time' => 'If you specify :session closing time for :day, you must also specify opening time.',
        'opening_before_closing' => 'The :session opening time for :day must be before closing time.',
    ],
];
