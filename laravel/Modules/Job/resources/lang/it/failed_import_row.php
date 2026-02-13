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
        ],
        'import_batch_id' => [
            'label' => 'ID batch importazione',
        ],
        'row_index' => [
            'label' => 'Indice riga',
        ],
        'errors' => [
            'label' => 'Errori',
        ],
        'data' => [
            'label' => 'Dati',
        ],
        'created_at' => [
            'label' => 'Creato il',
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
