<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Registros de Autenticación',
        'group' => 'Seguridad',
        'icon' => 'heroicon-o-lock-closed',
        'sort' => 36,
    ],
    'label' => 'Registro de Autenticación',
    'plural_label' => 'Registros de Autenticación',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuario',
        ],
        'ip_address' => [
            'label' => 'Dirección IP',
        ],
        'user_agent' => [
            'label' => 'Agente de Usuario',
        ],
        'login_at' => [
            'label' => 'Inicio de Sesión',
        ],
        'logout_at' => [
            'label' => 'Cierre de Sesión',
        ],
        'login_method' => [
            'label' => 'Método de Inicio de Sesión',
        ],
        'success' => [
            'label' => 'Éxito',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Ver Detalles',
        ],
        'export_logs' => [
            'label' => 'Exportar Registros',
        ],
        'reorderRecords' => [
            'tooltip' => 'Reordenar registros',
        ],
    ],
];
