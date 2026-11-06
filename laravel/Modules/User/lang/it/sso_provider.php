<?php

declare(strict_types=1);

return [
    'navigation' => ['label' => 'Provider SSO', 'group' => 'Authentication', 'icon' => 'heroicon-o-identification', 'sort' => 3],
    'label' => 'Provider SSO',
    'plural_label' => 'Provider SSO',
    'fields' => [
        'id' => ['label' => 'Identificativo', 'tooltip' => 'Identificativo univoco del record', 'helper_text' => '', 'description' => ''],
        'created_at' => ['label' => 'Data Creazione', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'updated_at' => ['label' => 'Ultima Modifica', 'tooltip' => '', 'helper_text' => '', 'description' => ''],
        'name' => ['label' => 'name'],
        'display_name' => ['label' => 'display_name'],
        'type' => ['label' => 'type'],
        'is_active' => ['label' => 'is_active'],
    ],
    'actions' => [
        'create' => ['label' => 'Crea Sso Provider'],
        'edit' => ['label' => 'Modifica Sso Provider'],
        'delete' => ['label' => 'Elimina Sso Provider'],
    ],
];
