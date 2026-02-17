<?php

declare(strict_types=1);

return [
    'OfflineEventAttendanceMode' => [
        'label' => 'In Presenza',
        'color' => 'primary',
        'icon' => 'heroicon-o-map-pin',
    ],
    'OnlineEventAttendanceMode' => [
        'label' => 'Online',
        'color' => 'success',
        'icon' => 'heroicon-o-computer-desktop',
    ],
    'MixedEventAttendanceMode' => [
        'label' => 'Mista',
        'color' => 'warning',
        'icon' => 'heroicon-o-arrows-right-left',
    ],
    'label' => 'Event Attendance Mode',
    'plural_label' => 'Event Attendance Mode (Plurale)',
    'navigation' => [
        'name' => 'Event Attendance Mode',
        'plural' => 'Event Attendance Mode',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Event Attendance Mode',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Event Attendance Mode',
        ],
        'edit' => [
            'label' => 'Modifica Event Attendance Mode',
        ],
        'delete' => [
            'label' => 'Elimina Event Attendance Mode',
        ],
    ],
];
