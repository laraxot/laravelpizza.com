<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Alternar layout da tabela',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Alternar layout',
                'tooltip' => 'Alternar entre visualização em lista e em grelha',
                'helper_text' => 'Alterar o tipo de visualização',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Selecionar tipo de layout',
            'tooltip' => 'Escolher entre visualização em lista e em grelha',
            'help' => 'Escolha o tipo de layout adequado para visualizar os dados',
        ],
    ],
];
