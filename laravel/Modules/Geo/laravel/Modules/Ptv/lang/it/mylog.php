<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Log',
        'group' => 'Sistema',
        'icon' => 'heroicon-o-clipboard-document-list',
        'sort' => 99,
    ],
    'label' => 'Log',
    'plural_label' => 'Log',
    'fields' => [
        'id_tbl' => [
            'label' => 'ID Tabella',
        ],
        'tbl' => [
            'label' => 'Tabella',
        ],
        'obj' => [
            'label' => 'Oggetto',
        ],
        'act' => [
            'label' => 'Azione',
        ],
        'note' => [
            'label' => 'Note',
        ],
        'data' => [
            'label' => 'Dati',
        ],
        'created_by' => [
            'label' => 'Creato da',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
    ],
];
