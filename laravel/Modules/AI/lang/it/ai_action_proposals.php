<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Assistente AI',
        'label' => 'Proposte di azione AI',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'thread' => [
            'public_id' => [
                'label' => 'Conversazione',
            ],
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'preview' => [
            'label' => 'Anteprima',
        ],
        'created_at' => [
            'label' => 'Creata il',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo',
        ],
        'layout' => [
            'label' => 'Layout',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'edit' => [
            'label' => 'Modifica',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
        'confirm' => [
            'label' => 'Conferma',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
