<?php

declare(strict_types=1);

return [
    'list_log_activities' => [
        'label' => 'History',
        'tooltip' => 'View modification history',
        'icon' => 'heroicon-o-clock',
        'color' => 'gray',
        'modal' => [
            'heading' => 'Modification History',
            'description' => 'View all modifications made to this record',
        ],
        'view_all' => 'View All',
        'close' => 'Close',
        'messages' => [
            'no_activities' => 'No modifications recorded for this record',
            'loading' => 'Loading history...',
        ],
    ],
];
