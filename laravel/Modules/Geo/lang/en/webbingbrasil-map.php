<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Webbingbrasil Map',
        'group' => 'Territory Management',
        'icon' => 'heroicon-o-map',
        'sort' => '60',
    ],
    'controls' => [
        'zoom' => [
            'in' => 'Zoom in',
            'out' => 'Zoom out',
        ],
        'fullscreen' => 'Fullscreen',
        'layers' => 'Change layer',
    ],
    'markers' => [
        'add' => 'Add marker',
        'remove' => 'Remove marker',
        'edit' => 'Edit marker',
    ],
    'messages' => [
        'marker_added' => 'Marker added successfully',
        'marker_removed' => 'Marker removed successfully',
        'marker_updated' => 'Marker updated successfully',
    ],
];
