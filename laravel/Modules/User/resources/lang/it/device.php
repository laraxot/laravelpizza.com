<?php

declare(strict_types=1);

return [
    'fields' => [
        'is_robot' => [
            'label' => 'È Robot',
            'helper_text' => 'Indica se il dispositivo è un robot',
        ],
        'is_desktop' => [
            'label' => 'È Desktop',
            'helper_text' => 'Indica se il dispositivo è un desktop',
        ],
        'is_mobile' => [
            'label' => 'È Mobile',
            'helper_text' => 'Indica se il dispositivo è mobile',
        ],
        'is_tablet' => [
            'label' => 'È Tablet',
            'helper_text' => 'Indica se il dispositivo è un tablet',
        ],
        'is_phone' => [
            'label' => 'È Telefono',
            'helper_text' => 'Indica se il dispositivo è un telefono',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Dispositivo',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica Dispositivo',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Elimina Dispositivo',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
        ],
    ],
];
