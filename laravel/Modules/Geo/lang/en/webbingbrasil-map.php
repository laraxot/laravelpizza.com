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
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'sections' => [
        'unavailable' => [
            'title' => 'Map temporarily unavailable',
        ],
    ],
    'unavailable' => [
        'disabled_notice' => [
            'description' => 'The map widget has been temporarily disabled during the migration to Filament v4.',
        ],
        'restore_notice' => [
            'description' => 'It will be restored as soon as compatible packages become available.',
        ],
    ],
];
