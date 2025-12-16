<?php

declare(strict_types=1);

return [
    'list' => [
        'label' => 'List',
        'description' => 'Traditional list view',
        'tooltip' => 'Show items in list format',
        'helper_text' => 'Traditional layout with rows and columns',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
    ],
    'grid' => [
        'label' => 'Grid',
        'description' => 'Grid view with cards',
        'tooltip' => 'Show items in grid format',
        'helper_text' => 'Grid layout with responsive cards',
        'color' => 'secondary',
        'icon' => 'heroicon-o-squares-2x2',
    ],
    'toggle' => [
        'label' => 'Toggle Layout',
        'tooltip' => 'Switch between list and grid view',
        'helper_text' => 'Change the display type',
    ],
];
