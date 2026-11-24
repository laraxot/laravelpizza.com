<?php

return [
    'navigation' => [
        'name' => 'Traduzione',
        'plural' => 'Traduzioni',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'pages' => [
        'create' => 'New Technician',
        'edit' => 'Edit Technician',
        'view' => 'Tecnico',
        'list_technicians' => [
            'navigation' => [
                'name' => 'Tecnici',
                'plural' => 'Tecnici',
                'group' => [
                    'name' => 'User Management',
                ],
            ],
            'fields' => [
                'user_name' => 'Username',
                'name' => 'Username',
                'first_name' => 'Name',
                'last_name' => 'Last name',
                'email' => 'Email',
                'is_active' => 'Account status',
                'color' => 'Colore',
                'asset_id_root' => 'Abitazione',
                'asset_id' => 'Asset',
                'type' => 'Type',
            ],
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'lang' => [
            'label' => 'Language',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'Value',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'key' => [
            'label' => 'Chiave',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'namespace' => [
            'label' => 'Namespace',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'group' => [
            'label' => 'Gruppo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'item' => [
            'label' => 'Elemento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Username',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Account status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'color' => [
            'label' => 'Colore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'asset_id_root' => [
            'label' => 'Abitazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'asset_id' => [
            'label' => 'Asset',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'type',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_name' => [
            'label' => 'username',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'filters' => [
        'is_active' => [
            'all' => 'All technicians',
            'active' => 'Active only',
            'inactive' => 'Inactive only',
        ],
    ],
    'actions' => [
        'bulk_activate' => [
            'cta' => 'Attiva selezionati',
        ],
        'bulk_inactivate' => [
            'cta' => 'Disattiva selezionati',
        ],
        'is_active_on' => [
            'cta' => 'Abilita account',
        ],
        'is_active_off' => [
            'cta' => 'Disabilita account',
        ],
    ],
    'act' => [
        'publish_item_trans' => 'pubblica modifiche riga',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
