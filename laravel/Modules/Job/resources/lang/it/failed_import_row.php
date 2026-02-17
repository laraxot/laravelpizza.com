<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Riga importazione fallita',
        'group' => 'Righe importazione',
        'icon' => 'heroicon-o-exclamation-circle',
        'sort' => 28,
    ],
    'label' => 'Riga importazione fallita',
    'plural_label' => 'Righe importazione fallite',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'import_batch_id' => [
            'label' => 'ID batch importazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'row_index' => [
            'label' => 'Indice riga',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'errors' => [
            'label' => 'Errori',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data' => [
            'label' => 'Dati',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_errors' => [
            'label' => 'Visualizza errori',
        ],
        'fix_row' => [
            'label' => 'Correggi riga',
        ],
    ],
];
