<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Autenticação',
        'icon' => 'heroicon-o-shield-exclamation',
        'label' => 'Registros de Autenticação',
        'sort' => 5,
    ],
    'label' => 'Registro de Autenticação',
    'plural_label' => 'Registros de Autenticação',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuário',
        ],
        'ip_address' => [
            'label' => 'Endereço IP',
        ],
        'user_agent' => [
            'label' => 'User Agent',
        ],
        'login_at' => [
            'label' => 'Acesso Em',
        ],
        'logout_at' => [
            'label' => 'Desconexão Em',
        ],
        'login_method' => [
            'label' => 'Método de Acesso',
        ],
        'success' => [
            'label' => 'Sucesso',
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'tooltip' => 'Reordenar Registros',
            'icon' => 'reorderRecords',
            'label' => 'Reordenar Registros',
        ],
        'view_details' => [
            'label' => 'Ver Detalhes',
        ],
        'export_logs' => [
            'label' => 'Exportar Registros',
        ],
    ],
];
