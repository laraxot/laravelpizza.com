<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icon' => 'heroicon-o-document-text',
        'group' => 'Monitorización',
        'label' => 'Registro',
    ],
    'title' => 'Registro del sistema',
    'tree' => [
        'heading' => 'Carpetas y archivos',
    ],
    'fields' => [
        'file' => 'Archivo',
        'level' => 'Nivel',
        'search' => 'Buscar en el texto',
        'window' => 'Parte a leer',
    ],
    'placeholders' => [
        'search' => 'Buscar en las entradas mostradas...',
        'all_levels' => 'Todos los niveles',
    ],
    'window_option' => 'Últimos :size',
    'actions' => [
        'refresh' => [
            'label' => 'Actualizar',
        ],
        'download' => [
            'label' => 'Descargar el archivo',
        ],
    ],
    'messages' => [
        'no_files' => 'No se encontraron archivos de registro en storage/logs.',
        'no_file_selected' => 'Elige un archivo de registro para consultar.',
        'file_unavailable' => 'El archivo de registro no está disponible: puede haber sido rotado o eliminado. Actualiza la lista.',
        'no_entries' => 'Ninguna entrada coincide con los filtros en la parte leída del archivo.',
        'summary' => 'Mostradas :shown de :total entradas coincidentes (de la más reciente).',
        'file_info' => ':size, última modificación :date',
        'partial_read' => 'Solo se han leído los últimos :read de :size. La búsqueda y los filtros se aplican a esta parte: usa «Descargar el archivo» para obtenerlo completo o amplía «Parte a leer».',
        'entry_omitted' => '... :count caracteres omitidos en el centro: usa «Descargar el archivo» para el texto completo ...',
        'sensitive' => 'Atención: los registros pueden contener datos personales (correos electrónicos, teléfonos) y otra información confidencial.',
    ],
];
