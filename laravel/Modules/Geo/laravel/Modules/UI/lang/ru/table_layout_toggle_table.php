<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Переключить макет таблицы',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Переключить макет',
                'tooltip' => 'Переключение между списочным и сеточным представлением',
                'helper_text' => 'Изменить тип отображения',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Макет',
            'placeholder' => 'Выбрать тип макета',
            'tooltip' => 'Выбрать между списочным и сеточным представлением',
            'help' => 'Выберите подходящий тип макета для отображения данных',
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
