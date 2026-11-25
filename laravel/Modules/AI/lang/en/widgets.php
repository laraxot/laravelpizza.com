<?php

declare(strict_types=1);

return [
    'base' => [
        'title' => 'Base widget',
        'description' => 'Base widget from which the other widgets derive.',
        'warning' => 'Warning',
        'abstract_widget_message' => 'This is an abstract widget and must not be used directly.',
    ],
    'infolist' => [
        'record_not_available' => [
            'label' => 'Content not available or not visible.',
        ],
    ],
    'modules_overview' => [
        'title' => 'Available Modules',
        'description' => 'Select a module to access its administration',
        'empty' => [
            'title' => 'No modules available',
            'description' => 'You do not have access to any administrative module.',
        ],
    ],
    'schema' => [
        'submit' => [
            'label' => 'Submit',
        ],
    ],
];
