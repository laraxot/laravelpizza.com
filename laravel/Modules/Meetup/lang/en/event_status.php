<?php

declare(strict_types=1);

return [
    // Chiavi lette da EnumTrait (getLabel/getColor/getIcon): values.<case>.<label|color|icon>
    'values' => [
        'draft' => [
            'label' => 'Draft',
            'color' => 'gray',
        ],
        'EventScheduled' => [
            'label' => 'Scheduled',
            'color' => 'success',
        ],
        'EventScheduled_confirmed' => [
            'label' => 'Confirmed',
            'color' => 'success',
        ],
        'EventCancelled' => [
            'label' => 'Cancelled',
            'color' => 'danger',
        ],
        'EventPostponed' => [
            'label' => 'Postponed',
            'color' => 'warning',
        ],
        'EventRescheduled' => [
            'label' => 'Rescheduled',
            'color' => 'info',
        ],
        'EventMovedOnline' => [
            'label' => 'Moved online',
            'color' => 'info',
        ],
        'completed' => [
            'label' => 'Completed',
            'color' => 'gray',
        ],
    ],
];
