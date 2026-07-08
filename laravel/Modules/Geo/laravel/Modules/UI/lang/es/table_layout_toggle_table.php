<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Alternar diseño de tabla',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Cambiar diseño',
                'tooltip' => 'Cambiar entre vista de lista y vista de cuadrícula',
                'helper_text' => 'Cambiar el tipo de visualización',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Diseño',
            'placeholder' => 'Seleccionar tipo de diseño',
            'tooltip' => 'Elegir entre vista de lista y vista de cuadrícula',
            'help' => 'Elija el tipo de diseño más adecuado para visualizar los datos',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
