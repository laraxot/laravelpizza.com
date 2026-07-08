<?php

declare(strict_types=1);

return [
    'backend' => [
        'none' => 'There is no recent history.',
        'none_for_type' => 'There is no history for this type.',
        'none_for_entity' => 'There is no history for this :entity.',
        'recent_history' => 'Recent History',
        'roles' => [
            'created' => 'created role',
            'deleted' => 'deleted role',
            'updated' => 'updated role',
        ],
        'users' => [
            'changed_password' => 'changed password for user',
            'created' => 'created user',
            'deactivated' => 'deactivated user',
            'deleted' => 'deleted user',
            'permanently_deleted' => 'permanently deleted user',
            'updated' => 'updated user',
            'reactivated' => 'reactivated user',
            'restored' => 'restored user',
        ],
    ],
    'label' => 'History',
    'plural_label' => 'History (Plurale)',
    'navigation' => [
        'name' => 'History',
        'plural' => 'History',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'History',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea History',
        ],
        'edit' => [
            'label' => 'Modifica History',
        ],
        'delete' => [
            'label' => 'Elimina History',
        ],
    ],
];
