<?php

declare(strict_types=1);

return [
    'submit' => 'Crear una cuenta',
    'already_registered' => '¿Ya tienes una cuenta?',
    'fields' => [
        'first_name' => ['label' => 'Nombre', 'placeholder' => 'Introduce tu nombre'],
        'last_name' => ['label' => 'Apellidos', 'placeholder' => 'Introduce tus apellidos'],
        'email' => ['label' => 'Correo electrónico', 'placeholder' => 'Introduce tu correo electrónico'],
        'password' => ['label' => 'Contraseña', 'placeholder' => 'Introduce tu contraseña'],
        'password_confirmation' => ['label' => 'Confirmar contraseña', 'placeholder' => 'Repite tu contraseña'],
    ],
    'actions' => [
        'register' => [
            'label' => 'Crear una cuenta',
            'tooltip' => 'Completa el registro',
            'modal_heading' => 'Confirmar registro',
            'modal_description' => '¿Quieres completar el registro con los datos introducidos?',
            'success' => 'Registro completado correctamente',
            'error' => 'Se produjo un error durante el registro',
        ],
    ],
];
