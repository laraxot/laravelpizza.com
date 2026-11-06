<?php

declare(strict_types=1);

return [
    'actions' => [
        'clear_filters' => [
            'label' => 'Borrar filtros',
        ],
        'export_csv' => [
            'label' => 'Exportar CSV',
        ],
        'export_json' => [
            'label' => 'Exportar JSON',
        ],
        'reset_view' => [
            'label' => 'Restablecer vista',
        ],
    ],
    'sections' => [
        'actions' => [
            'title' => 'Acciones',
        ],
        'search' => [
            'title' => 'Búsqueda',
        ],
        'stats' => [
            'title' => 'Estadísticas',
        ],
    ],
    'filters' => [
        'locations' => [
            'label' => 'Lugares',
        ],
        'ticket_status' => [
            'label' => 'Estado del ticket',
        ],
        'tickets' => [
            'label' => 'Tickets',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'users' => [
            'label' => 'Usuarios',
        ],
    ],
    'fields' => [
        'loading' => [
            'label' => 'Cargando...',
        ],
        'search' => [
            'placeholder' => 'Buscar dirección...',
        ],
    ],
    'loading' => [
        'markers' => [
            'label' => 'Cargando marcadores...',
        ],
    ],
    'marker' => [
        'select' => [
            'label' => 'Seleccionar',
        ],
        'unknown_user' => [
            'message' => 'Desconocido',
        ],
        'view' => [
            'label' => 'Ver',
        ],
    ],
    'stats' => [
        'filtered' => [
            'label' => 'Filtrados',
        ],
        'total_markers' => [
            'label' => 'Total de marcadores',
        ],
        'visible' => [
            'label' => 'Visibles',
        ],
    ],
    'status' => [
        'assigned' => [
            'label' => 'Asignado',
        ],
        'in_progress' => [
            'label' => 'En curso',
        ],
        'pending' => [
            'label' => 'Pendiente',
        ],
        'resolved' => [
            'label' => 'Resuelto',
        ],
    ],
];
