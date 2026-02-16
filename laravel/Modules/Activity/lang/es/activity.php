<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Actividad',
    'plural' => 'Actividades',
    'group' => 
    array (
      'name' => 'Monitoreo',
      'description' => 'Monitoreo de actividad del sistema',
    ),
    'label' => 'Actividad',
    'sort' => '60',
    'icon' => 'heroicon-o-activity',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'Usuario',
      'placeholder' => 'Seleccione un usuario',
      'help' => 'El usuario que realizó la acción',
      'name' => 
      array (
        'label' => 'Nombre',
        'placeholder' => 'Ingrese el nombre',
        'help' => 'Nombre completo del usuario',
        'validation' => 'required|string|max:255',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Ingrese el email',
        'help' => 'Dirección de email del usuario',
        'validation' => 'required|email|max:255',
      ),
      'role' => 
      array (
        'label' => 'Rol',
        'placeholder' => 'Seleccione un rol',
        'help' => 'Rol del usuario en el sistema',
        'validation' => 'required|string',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'action' => 
    array (
      'label' => 'Acción',
      'placeholder' => 'Seleccione una acción',
      'help' => 'Tipo de acción realizada',
      'validation' => 'required|string',
      'options' => 
      array (
        'created' => 
        array (
          'label' => 'Creado',
          'icon' => 'heroicon-o-plus-circle',
          'color' => 'success',
        ),
        'updated' => 
        array (
          'label' => 'Actualizado',
          'icon' => 'heroicon-o-pencil',
          'color' => 'warning',
        ),
        'deleted' => 
        array (
          'label' => 'Eliminado',
          'icon' => 'heroicon-o-trash',
          'color' => 'danger',
        ),
        'viewed' => 
        array (
          'label' => 'Visto',
          'icon' => 'heroicon-o-eye',
          'color' => 'info',
        ),
        'downloaded' => 
        array (
          'label' => 'Descargado',
          'icon' => 'heroicon-o-arrow-down-tray',
          'color' => 'primary',
        ),
        'uploaded' => 
        array (
          'label' => 'Subido',
          'icon' => 'heroicon-o-arrow-up-tray',
          'color' => 'primary',
        ),
        'logged_in' => 
        array (
          'label' => 'Inició sesión',
          'icon' => 'heroicon-o-arrow-right-on-rectangle',
          'color' => 'success',
        ),
        'logged_out' => 
        array (
          'label' => 'Cerró sesión',
          'icon' => 'heroicon-o-arrow-left-on-rectangle',
          'color' => 'gray',
        ),
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'subject' => 
    array (
      'label' => 'Asunto',
      'placeholder' => 'Seleccione un asunto',
      'help' => 'El objeto afectado por la acción',
      'type' => 
      array (
        'label' => 'Tipo',
        'placeholder' => 'Tipo de objeto',
        'help' => 'Clase o tipo del objeto',
        'validation' => 'nullable|string|max:255',
      ),
      'id' => 
      array (
        'label' => 'ID',
        'placeholder' => 'ID del objeto',
        'help' => 'Identificador único del objeto',
        'validation' => 'nullable|integer|min:1',
      ),
      'name' => 
      array (
        'label' => 'Nombre',
        'placeholder' => 'Nombre del objeto',
        'help' => 'Nombre descriptivo del objeto',
        'validation' => 'nullable|string|max:255',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descripción',
      'placeholder' => 'Ingrese una descripción',
      'help' => 'Descripción detallada de la actividad',
      'validation' => 'nullable|string|max:1000',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'Dirección IP',
      'placeholder' => 'Ej. 192.168.1.1',
      'help' => 'Dirección IP desde la que se realizó la acción',
      'validation' => 'nullable|ip',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => 'Agente de Usuario',
      'placeholder' => 'Navegador y sistema operativo',
      'help' => 'Información sobre el navegador y sistema del usuario',
      'validation' => 'nullable|string|max:500',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Fecha',
      'placeholder' => 'Seleccione fecha y hora',
      'help' => 'Fecha y hora en que se creó la actividad',
      'validation' => 'required|date',
      'format' => 'd/m/Y H:i:s',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'properties' => 
    array (
      'label' => 'Propiedades',
      'placeholder' => 'Propiedades adicionales',
      'help' => 'Datos adicionales de la actividad',
      'old' => 
      array (
        'label' => 'Valor Anterior',
        'placeholder' => 'Valor anterior',
        'help' => 'Valor antes del cambio',
      ),
      'new' => 
      array (
        'label' => 'Valor Nuevo',
        'placeholder' => 'Valor actual',
        'help' => 'Valor después del cambio',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostrar/Ocultar Columnas',
      'help' => 'Configurar visibilidad de columnas',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Reordenar Registros',
      'help' => 'Reordenar registros en la tabla',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'Restablecer Filtros',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'Aplicar Filtros',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'user' => 
    array (
      'label' => 'Usuario',
      'placeholder' => 'Filtrar por usuario',
      'help' => 'Filtrar actividades por usuario',
      'type' => 'select',
      'searchable' => '1',
    ),
    'action' => 
    array (
      'label' => 'Acción',
      'placeholder' => 'Filtrar por acción',
      'help' => 'Filtrar actividades por tipo de acción',
      'type' => 'select',
      'multiple' => '1',
    ),
    'subject_type' => 
    array (
      'label' => 'Tipo de Asunto',
      'placeholder' => 'Filtrar por tipo de asunto',
      'help' => 'Filtrar actividades por tipo de asunto',
      'type' => 'select',
      'searchable' => '1',
    ),
    'date_range' => 
    array (
      'label' => 'Rango de Fecha',
      'placeholder' => 'Seleccionar rango',
      'help' => 'Filtrar actividades por rango de fecha',
      'type' => 'date_range',
      'presets' => 
      array (
        'today' => 'Hoy',
        'yesterday' => 'Ayer',
        'last_7_days' => 'Últimos 7 Días',
        'last_30_days' => 'Últimos 30 Días',
        'this_month' => 'Este Mes',
        'last_month' => 'Mes Pasado',
      ),
    ),
    'ip_address' => 
    array (
      'label' => 'Dirección IP',
      'placeholder' => 'Filtrar por IP',
      'help' => 'Filtrar actividades por dirección IP',
      'type' => 'text',
    ),
  ),
  'actions' => 
  array (
    'view_details' => 
    array (
      'label' => 'Ver Detalles',
      'icon' => 'heroicon-o-eye',
      'color' => 'primary',
      'success' => 'Detalles cargados exitosamente',
      'error' => 'Error al cargar detalles',
      'confirmation' => '¿Desea ver los detalles de esta actividad?',
    ),
    'export' => 
    array (
      'label' => 'Exportar',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'success',
      'success' => 'Exportación completada exitosamente',
      'error' => 'Error durante la exportación',
      'confirmation' => '¿Desea exportar las actividades seleccionadas?',
    ),
    'clear_old' => 
    array (
      'label' => 'Limpiar Antiguas',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Actividades antiguas eliminadas exitosamente',
      'error' => 'Error al limpiar actividades',
      'confirmation' => '¿Está seguro de que desea eliminar las actividades antiguas? Esta acción no se puede deshacer.',
      'days_threshold' => '90',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Eliminar Seleccionadas',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'success' => 'Actividades seleccionadas eliminadas exitosamente',
      'error' => 'Error al eliminar actividades',
      'confirmation' => '¿Está seguro de que desea eliminar las actividades seleccionadas?',
    ),
  ),
  'messages' => 
  array (
    'no_activities' => 'No se encontraron actividades para los filtros seleccionados',
    'cleared' => 'Actividades antiguas eliminadas exitosamente',
    'exported' => 'Actividades exportadas exitosamente',
    'loading' => 'Cargando actividades...',
    'error_loading' => 'Error al cargar actividades',
    'empty_state' => 
    array (
      'title' => 'No hay actividades registradas',
      'description' => 'Aún no hay actividades para mostrar. Las actividades aparecerán aquí cuando los usuarios comiencen a interactuar con el sistema.',
    ),
  ),
  'export' => 
  array (
    'formats' => 
    array (
      'csv' => 
      array (
        'label' => 'CSV',
        'mime_type' => 'text/csv',
        'extension' => 'csv',
        'icon' => 'heroicon-o-document-text',
      ),
      'excel' => 
      array (
        'label' => 'Excel',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'extension' => 'xlsx',
        'icon' => 'heroicon-o-table-cells',
      ),
      'pdf' => 
      array (
        'label' => 'PDF',
        'mime_type' => 'application/pdf',
        'extension' => 'pdf',
        'icon' => 'heroicon-o-document',
      ),
    ),
    'columns' => 
    array (
      'date' => 
      array (
        'label' => 'Fecha',
        'format' => 'd/m/Y H:i:s',
        'sortable' => '1',
      ),
      'user' => 
      array (
        'label' => 'Usuario',
        'sortable' => '1',
      ),
      'action' => 
      array (
        'label' => 'Acción',
        'sortable' => '1',
      ),
      'subject' => 
      array (
        'label' => 'Asunto',
        'sortable' => '',
      ),
      'ip' => 
      array (
        'label' => 'IP',
        'sortable' => '1',
      ),
      'description' => 
      array (
        'label' => 'Descripción',
        'sortable' => '',
      ),
    ),
    'filename_pattern' => 'actividad_{date}_{time}',
    'max_records' => '10000',
  ),
  'permissions' => 
  array (
    'view' => 'activities.view',
    'create' => 'activities.create',
    'update' => 'activities.update',
    'delete' => 'activities.delete',
    'export' => 'activities.export',
    'clear_old' => 'activities.clear_old',
  ),
  'pagination' => 
  array (
    'per_page' => '25',
    'options' => 
    array (
      0 => '10',
      1 => '25',
      2 => '50',
      3 => '100',
    ),
  ),
  'cache' => 
  array (
    'ttl' => '300',
    'tags' => 
    array (
      0 => 'activities',
      1 => 'monitoring',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
