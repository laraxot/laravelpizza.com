<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => [
            'name' => 'Notificaciones',
            'description' => 'Gestión de notificaciones por correo electrónico y sus plantillas',
        ],
        'label' => 'Plantillas de Email',
        'plural' => 'Plantillas de Email',
        'singular' => 'Plantilla de Email',
        'icon' => 'heroicon-o-envelope',
        'sort' => '1',
        'name' => 'Plantilla de Email',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'helper_text' => 'Identificador único de la plantilla',
        ],
        'mailable' => [
            'label' => 'Clase Mailable',
            'placeholder' => 'Ingrese el nombre de la clase Mailable',
            'help' => 'La clase PHP que maneja el envío de correos electrónicos',
            'helper_text' => 'Clase PHP que gestiona el envío de correos electrónicos',
            'description' => 'mailable',
        ],
        'subject' => [
            'label' => 'Asunto',
            'placeholder' => 'Ingrese el asunto del correo electrónico',
            'help' => 'El asunto que aparecerá en el correo electrónico',
            'helper_text' => 'Asunto del correo electrónico',
            'description' => 'subject',
        ],
        'html_template' => [
            'label' => 'Contenido HTML',
            'placeholder' => 'Ingrese el contenido HTML del correo electrónico',
            'help' => 'El contenido del correo electrónico en formato HTML',
            'helper_text' => 'Contenido HTML de la plantilla de correo electrónico',
            'description' => 'html_template',
        ],
        'text_template' => [
            'label' => 'Contenido de Texto',
            'placeholder' => 'Ingrese el contenido de texto del correo electrónico',
            'help' => 'Versión de texto del correo electrónico para clientes que no admiten HTML',
            'helper_text' => 'Versión de texto de la plantilla de correo electrónico',
            'description' => 'text_template',
        ],
        'version' => [
            'label' => 'Versión',
            'help' => 'Número de versión de la plantilla',
        ],
        'created_at' => [
            'label' => 'Creado el',
            'helper_text' => 'Fecha de creación de la plantilla',
        ],
        'updated_at' => [
            'label' => 'Última Modificación',
            'helper_text' => 'Fecha de la última modificación de la plantilla',
        ],
        'from_email' => [
            'label' => 'Email del remitente',
            'helper_text' => 'Dirección de correo electrónico del remitente',
            'placeholder' => 'noreply@ejemplo.com',
        ],
        'from_name' => [
            'label' => 'Nombre del remitente',
            'helper_text' => 'Nombre mostrado del remitente',
            'placeholder' => 'Nombre de la Empresa',
        ],
        'variables' => [
            'label' => 'Variables disponibles',
            'helper_text' => 'Lista de variables que se pueden utilizar en la plantilla',
            'placeholder' => 'ej: {{name}}, {{email}}',
        ],
        'is_markdown' => [
            'label' => 'Usar Markdown',
            'helper_text' => 'Indica si la plantilla utiliza sintaxis Markdown',
        ],
        'status' => [
            'label' => 'Estado',
            'helper_text' => 'Estado actual de la plantilla',
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
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'slug' => [
            'label' => 'slug',
            'description' => 'slug',
            'helper_text' => 'slug',
            'placeholder' => 'slug',
        ],
        'name' => [
            'description' => 'Nombre de la plantilla',
            'helper_text' => 'Nombre descriptivo para identificar la plantilla',
            'placeholder' => 'Ej: Bienvenida, Confirmación de pedido, Restablecer contraseña',
            'label' => 'Nombre de la Plantilla',
        ],
        'params' => [
            'label' => 'Parámetros',
            'helper_text' => 'Ingrese los parámetros separados por comas que se pueden utilizar en la plantilla',
            'placeholder' => 'name, email, date, company',
            'description' => 'Parámetros disponibles para la plantilla de correo electrónico',
        ],
    ],
    'filters' => [
        'search_placeholder' => 'Buscar plantillas...',
        'version' => [
            'label' => 'Versión',
            'placeholder' => 'Seleccionar versión',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nueva Plantilla',
            'modal' => [
                'heading' => 'Crear Plantilla de Email',
                'description' => 'Ingrese los detalles para la nueva plantilla de email',
                'submit' => 'Crear',
            ],
        ],
        'edit' => [
            'label' => 'Editar',
            'modal' => [
                'heading' => 'Editar Plantilla de Email',
                'description' => 'Modificar los detalles de la plantilla de email',
                'submit' => 'Guardar',
            ],
        ],
        'delete' => [
            'label' => 'Eliminar',
            'modal' => [
                'heading' => 'Eliminar Plantilla de Email',
                'description' => '¿Está seguro de que desea eliminar esta plantilla? Esta acción no se puede deshacer.',
                'submit' => 'Eliminar',
            ],
        ],
        'restore' => [
            'label' => 'Restaurar',
        ],
        'force_delete' => [
            'label' => 'Eliminar Permanentemente',
            'modal' => [
                'heading' => 'Eliminar Permanentemente Plantilla de Email',
                'description' => '¿Está seguro de que desea eliminar permanentemente esta plantilla? Esta acción no se puede deshacer.',
                'submit' => 'Eliminar Permanentemente',
            ],
        ],
        'new_version' => [
            'label' => 'Nueva Versión',
            'modal' => [
                'heading' => 'Crear Nueva Versión',
                'description' => 'Crear una nueva versión de la plantilla de email',
                'submit' => 'Crear Versión',
            ],
        ],
        'preview' => [
            'label' => 'Vista previa',
            'tooltip' => 'Visualizar vista previa del correo electrónico',
            'success_message' => 'Vista previa generada con éxito',
            'error_message' => 'Error al generar la vista previa',
        ],
        'test' => [
            'label' => 'Enviar prueba',
            'tooltip' => 'Enviar un correo electrónico de prueba',
            'success_message' => 'Correo electrónico de prueba enviado con éxito',
            'error_message' => 'Error al enviar el correo electrónico de prueba',
        ],
        'duplicate' => [
            'label' => 'Duplicar',
            'tooltip' => 'Crear una copia de la plantilla',
            'success_message' => 'Plantilla duplicada con éxito',
            'error_message' => 'Error al duplicar la plantilla',
        ],
        'export' => [
            'label' => 'Exportar',
            'tooltip' => 'Exportar la plantilla en formato JSON',
            'success_message' => 'Plantilla exportada con éxito',
            'error_message' => 'Error al exportar la plantilla',
        ],
        'import' => [
            'label' => 'Importar',
            'tooltip' => 'Importar una plantilla desde un archivo JSON',
            'success_message' => 'Plantilla importada con éxito',
            'error_message' => 'Error al importar la plantilla',
        ],
    ],
    'messages' => [
        'created' => 'Plantilla de email creada exitosamente.',
        'updated' => 'Plantilla de email actualizada exitosamente.',
        'deleted' => 'Plantilla de email eliminada exitosamente.',
        'restored' => 'Plantilla de email restaurada exitosamente.',
        'force_deleted' => 'Plantilla de email eliminada permanentemente.',
        'version_created' => 'Nueva versión de plantilla creada exitosamente.',
        'success' => 'Operación completada con éxito',
        'error' => 'Ocurrió un error durante la operación',
        'confirmation' => '¿Está seguro de que desea proceder con esta operación?',
        'template_created' => 'La plantilla de email ha sido creada con éxito',
        'template_updated' => 'La plantilla de email ha sido actualizada con éxito',
        'template_deleted' => 'La plantilla de email ha sido eliminada con éxito',
    ],
    'sections' => [
        'template' => [
            'label' => 'Plantilla',
            'description' => 'Información principal de la plantilla',
        ],
        'versions' => [
            'label' => 'Versiones',
            'description' => 'Historial de versiones de la plantilla',
        ],
        'logs' => [
            'label' => 'Registros',
            'description' => 'Historial de envío de la plantilla',
        ],
        'main' => 'Información Principal',
        'content' => 'Contenido',
        'styling' => 'Estilo',
        'settings' => 'Configuraciones',
        'variables' => 'Variables',
    ],
    'status' => [
        'sent' => 'Enviado',
        'delivered' => 'Entregado',
        'failed' => 'Fallido',
        'opened' => 'Abierto',
        'clicked' => 'Clicado',
        'bounced' => 'Rebotado',
        'spam' => 'Marcado como spam',
    ],
    'model' => [
        'label' => 'plantilla de correo',
    ],
];
