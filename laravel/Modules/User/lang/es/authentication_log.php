<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Log de autenticación',
        'group' => 'Seguridad',
        'icon' => 'heroicon-o-lock-closed',
        'sort' => 36,
    ],
    'label' => 'Log de autenticación',
    'plural_label' => 'Logs de autenticación',
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
            'label' => 'Agente de usuario',
        ],
        'login_at' => [
            'label' => 'Inicio de sesión en',
        ],
        'logout_at' => [
            'label' => 'Cierre de sesión en',
        ],
        'login_method' => [
            'label' => 'Método de inicio de sesión',
        ],
        'success' => [
            'label' => 'Éxito',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Ver detalles',
        ],
        'export_logs' => [
            'label' => 'Exportar logs',
        ],
    ],
];
