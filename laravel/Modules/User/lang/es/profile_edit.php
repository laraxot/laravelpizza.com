<?php

declare(strict_types=1);

return [
    'sections' => [
        'profile_information' => [
            'title' => 'Información del perfil',
            'description' => 'Actualiza la información del perfil y la dirección de correo electrónico de tu cuenta.',
        ],
        'update_password' => [
            'description' => 'Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerla segura.',
        ],
        'delete_account' => [
            'description' => 'Una vez eliminada tu cuenta, todos sus recursos y datos se eliminarán de forma permanente. Antes de eliminar tu cuenta, descarga los datos o la información que desees conservar.',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nombre',
        ],
        'last_name' => [
            'label' => 'Apellido',
        ],
        'current_password' => [
            'label' => 'Contraseña actual',
        ],
        'new_password' => [
            'label' => 'Nueva contraseña',
        ],
        'confirm_new_password' => [
            'label' => 'Confirmar nueva contraseña',
        ],
    ],
    'actions' => [
        'update_profile' => [
            'label' => 'Actualizar perfil',
        ],
        'update_password' => [
            'label' => 'Actualizar contraseña',
        ],
        'delete_account' => [
            'label' => 'Eliminar cuenta',
        ],
    ],
    'modal' => [
        'delete_confirmation' => [
            'title' => '¿Seguro que quieres eliminar tu cuenta?',
            'message' => 'Una vez eliminada tu cuenta, todos sus recursos y datos se eliminarán de forma permanente. Introduce tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.',
            'placeholder' => 'Introduce tu contraseña para confirmar la eliminación',
        ],
    ],
];
