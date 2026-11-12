<?php

declare(strict_types=1);

return [
    // Chiavi lette da EnumTrait (getLabel/getColor/getIcon): values.<case>.<label|color|icon>
    'values' => [
        'OfflineEventAttendanceMode' => [
            'label' => 'In presenza',
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
    ],
];
