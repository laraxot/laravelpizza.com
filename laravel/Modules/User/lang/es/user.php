<?php

declare(strict_types=1);

return [
    'actions' => [
        'attach_user' => 'Adjuntar Usuario',
        'associate_user' => 'Asociar Usuario',
        'user_actions' => 'Acciones del Usuario',
        'view' => 'Ver',
        'edit' => 'Editar',
        'detach' => 'Desvincular',
        'row_actions' => 'Acciones',
        'delete_selected' => 'Eliminar Seleccionados',
        'confirm_detach' => '¿Está seguro de que desea desvincular este usuario?',
        'confirm_delete' => '¿Está seguro de que desea eliminar los usuarios seleccionados?',
        'success_attached' => 'Usuario adjuntado exitosamente',
        'success_detached' => 'Usuario desvinculado exitosamente',
        'success_deleted' => 'Usuarios eliminados exitosamente',
        'toggle_layout' => 'Alternar Diseño',
        'create' => 'Crear Usuario',
        'delete' => 'Eliminar Usuario',
        'associate' => 'Asociar Usuario',
        'bulk_delete' => 'Eliminar Seleccionados',
        'bulk_detach' => 'Desvincular Seleccionados',
        'impersonate' => 'Suplantar Usuario',
        'stop_impersonating' => 'Detener Suplantación',
        'block' => 'Bloquear',
        'unblock' => 'Desbloquear',
        'send_reset_link' => 'Enviar Enlace de Restablecimiento',
        'verify_email' => 'Verificar Email',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nombre',
            'placeholder' => 'Ingrese el nombre',
            'description' => 'nombre',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Ingrese el email',
            'description' => 'email',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Fecha de Creación',
        ],
        'updated_at' => [
            'label' => 'Última Modificación',
        ],
        'role' => [
            'label' => 'Rol',
        ],
        'active' => 'Activo',
        'id' => [
            'label' => 'ID',
        ],
        'password' => [
            'label' => 'Contraseña',
            'placeholder' => 'Ingrese la contraseña',
            'description' => 'contraseña',
            'helper_text' => '',
        ],
        'password_confirmation' => [
            'label' => 'Confirmar Contraseña',
            'placeholder' => 'Confirme la contraseña',
        ],
        'email_verified_at' => [
            'label' => 'Email Verificado el',
        ],
        'current_password' => [
            'label' => 'Contraseña Actual',
            'placeholder' => 'Ingrese la contraseña actual',
        ],
        'roles' => [
            'label' => 'Roles',
        ],
        'permissions' => [
            'label' => 'Permisos',
        ],
        'status' => [
            'label' => 'Estado',
            'options' => [
                'active' => 'Activo',
                'inactive' => 'Inactivo',
                'blocked' => 'Bloqueado',
            ],
        ],
        'last_login' => [
            'label' => 'Último Inicio de Sesión',
        ],
        'avatar' => [
            'label' => 'Avatar',
        ],
        'language' => [
            'label' => 'Idioma',
        ],
        'timezone' => [
            'label' => 'Zona Horaria',
        ],
        'password_expires_at' => [
            'label' => 'Expiración de Contraseña',
        ],
        'verified' => [
            'label' => 'Verificado',
        ],
        'unverified' => [
            'label' => 'No Verificado',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'isActive' => [
            'label' => 'isActive',
        ],
        'deactivate' => [
            'label' => 'deactivate',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'changePassword' => [
            'label' => 'changePassword',
        ],
    ],
    'filters' => [
        'active_users' => 'Usuarios Activos',
        'creation_date' => 'Fecha de Creación',
        'date_from' => 'Desde',
        'date_to' => 'Hasta',
        'verified' => 'Usuarios Verificados',
        'unverified' => 'Usuarios No Verificados',
    ],
    'messages' => [
        'no_records' => 'No se encontraron usuarios',
        'loading' => 'Cargando usuarios...',
        'search' => 'Buscar usuarios...',
        'credentials_incorrect' => 'Las credenciales proporcionadas son incorrectas.',
        'created' => 'Usuario creado exitosamente',
        'updated' => 'Usuario actualizado exitosamente',
        'deleted' => 'Usuario eliminado exitosamente',
        'blocked' => 'Usuario bloqueado exitosamente',
        'unblocked' => 'Usuario desbloqueado exitosamente',
        'reset_link_sent' => 'Enlace de restablecimiento enviado',
        'email_verified' => 'Email verificado exitosamente',
        'impersonating' => 'Estás suplantando al usuario :name',
        'login_success' => 'Inicio de sesión exitoso',
        'validation_error' => 'Error de validación',
        'login_error' => 'Ocurrió un error durante el inicio de sesión. Por favor, inténtelo de nuevo más tarde.',
    ],
    'modals' => [
        'create' => [
            'heading' => 'Crear Usuario',
            'description' => 'Crear un nuevo registro de usuario',
            'actions' => [
                'submit' => 'Crear',
                'cancel' => 'Cancelar',
            ],
        ],
        'edit' => [
            'heading' => 'Editar Usuario',
            'description' => 'Modificar información del usuario',
            'actions' => [
                'submit' => 'Guardar Cambios',
                'cancel' => 'Cancelar',
            ],
        ],
        'delete' => [
            'heading' => 'Eliminar Usuario',
            'description' => '¿Está seguro de que desea eliminar este usuario?',
            'actions' => [
                'submit' => 'Eliminar',
                'cancel' => 'Cancelar',
            ],
        ],
        'associate' => [
            'heading' => 'Asociar Usuario',
            'description' => 'Seleccione un usuario para asociar',
            'actions' => [
                'submit' => 'Asociar',
                'cancel' => 'Cancelar',
            ],
        ],
        'detach' => [
            'heading' => 'Desvincular Usuario',
            'description' => '¿Está seguro de que desea desvincular este usuario?',
            'actions' => [
                'submit' => 'Desvincular',
                'cancel' => 'Cancelar',
            ],
        ],
        'bulk_delete' => [
            'heading' => 'Eliminar Usuarios Seleccionados',
            'description' => '¿Está seguro de que desea eliminar los usuarios seleccionados?',
            'actions' => [
                'submit' => 'Eliminar Seleccionados',
                'cancel' => 'Cancelar',
            ],
        ],
        'bulk_detach' => [
            'heading' => 'Desvincular Usuarios Seleccionados',
            'description' => '¿Está seguro de que desea desvincular los usuarios seleccionados?',
            'actions' => [
                'submit' => 'Desvincular Seleccionados',
                'cancel' => 'Cancelar',
            ],
        ],
    ],
    'navigation' => [
        'name' => 'Usuarios',
        'plural' => 'Usuarios',
        'group' => [
            'name' => 'Gestión de Usuarios',
            'description' => 'Gestión de usuarios y sus permisos',
        ],
        'label' => 'Usuarios',
        'sort' => '26',
        'icon' => 'user-main',
    ],
    'validation' => [
        'email_unique' => 'Este email ya está en uso',
        'password_min' => 'La contraseña debe tener al menos :min caracteres',
        'password_confirmed' => 'Las contraseñas no coinciden',
        'current_password' => 'La contraseña actual no es correcta',
    ],
    'permissions' => [
        'view_users' => 'Ver usuarios',
        'create_users' => 'Crear usuarios',
        'edit_users' => 'Editar usuarios',
        'delete_users' => 'Eliminar usuarios',
        'impersonate_users' => 'Suplantar usuarios',
        'manage_roles' => 'Gestionar roles',
    ],
    'model' => [
        'label' => 'Usuario',
    ],
];
