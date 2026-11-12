<?php

declare(strict_types=1);

// Pagina "Modifica il profilo" (/{lingua}/profile/edit): Modules\Meetup\Http\Livewire\ProfileEditForm
return [
    'link' => 'Editar perfil',
    'sections' => [
        'data' => ['title' => 'Tus datos', 'description' => 'Tu nombre y tu biografía aparecen en tu perfil público y en las listas de asistentes.'],
        'photo' => ['title' => 'Foto', 'description' => 'Opcional. Sin foto mostramos tus iniciales.'],
        'password' => ['title' => 'Contraseña', 'description' => 'Escribe primero la contraseña actual. Se cerrarán las demás sesiones abiertas.'],
    ],
    'fields' => [
        'first_name' => 'Nombre',
        'last_name' => 'Apellidos',
        'email' => 'Email',
        'bio' => 'Biografía',
        'locale' => 'Idioma preferido',
        'photo' => 'Nueva foto',
        'current_password' => 'Contraseña actual',
        'password' => 'Nueva contraseña',
        'password_confirmation' => 'Repite la nueva contraseña',
    ],
    'help' => [
        'email' => 'El email no se cambia desde aquí: escríbenos desde la página de Contacto si lo necesitas.',
        'bio' => 'Máximo 500 caracteres. Visible para todos.',
        'locale' => 'El idioma de los emails que te enviamos.',
        'photo' => 'JPG, PNG o WebP, máximo 2 MB.',
    ],
    'placeholders' => [
        'bio' => 'Un par de líneas sobre ti: a qué te dedicas, con qué trabajas, qué te gustaría aprender.',
    ],
    'actions' => [
        'save_profile' => 'Guardar datos',
        'view_public' => 'Ver el perfil público',
        'save_photo' => 'Subir la foto',
        'remove_photo' => 'Quitar la foto',
        'change_password' => 'Cambiar la contraseña',
    ],
    'saved' => [
        'profile' => 'Datos guardados.',
        'photo' => 'Foto actualizada.',
        'password' => 'Contraseña cambiada.',
    ],
    'photo' => [
        'uploading' => 'Subiendo…',
        'preview_alt' => 'Vista previa de la nueva foto',
        'current_alt' => 'Tu foto actual',
    ],
];
