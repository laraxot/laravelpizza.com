<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nombre',
            'placeholder' => 'Ingrese el nombre',
            'help' => 'Nombre identificativo del elemento',
            'description' => 'Nombre del objeto',
            'helper_text' => '',
        ],
        'edit-name' => [
            'label' => 'Editar nombre',
            'placeholder' => 'Nuevo nombre',
            'help' => 'Modificar el nombre existente',
            'description' => 'Acción para modificar el nombre',
            'helper_text' => '',
        ],
        'change-state' => [
            'label' => 'Cambiar estado',
            'placeholder' => 'Seleccionar nuevo estado',
            'help' => 'Modificar el estado actual',
            'description' => 'Acción para cambiar el estado',
            'helper_text' => '',
        ],
        'state' => [
            'label' => 'Estado',
            'placeholder' => 'Seleccionar un estado',
            'help' => 'Estado actual del elemento',
            'description' => 'Condición actual del sistema',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'Mensaje',
            'placeholder' => 'Ingrese un mensaje',
            'help' => 'Mensaje informativo',
            'description' => 'Texto del mensaje',
            'helper_text' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Instancia de estado no válida',
        'record_not_found' => 'Registro no encontrado',
        'transition_completed' => [
            'title' => 'Transición completada',
            'body' => 'La transición de estado se ha completado exitosamente',
        ],
        'transition_error' => [
            'title' => 'Error en la transición',
        ],
    ],
];
