<?php

declare(strict_types=1);

return [
    'fields' => [
        'latitude' => [
            'label' => 'Latitud',
            'placeholder' => 'Introduce la latitud',
        ],
        'longitude' => [
            'label' => 'Longitud',
            'placeholder' => 'Introduce la longitud',
        ],
    ],
    'address_form' => [
        'section' => [
            'heading' => 'Coordenadas',
            'description' => 'Latitud y longitud. Guarda primero la dirección y actualiza las coordenadas para distancia y mapa.',
        ],
        'geocode' => [
            'label' => 'Actualizar desde dirección',
            'success_title' => 'Coordenadas actualizadas desde la dirección',
            'failed_title' => 'Geocodificación fallida',
        ],
        'map' => [
            'heading' => 'Mapa de ubicación',
            'aria_label' => 'Mapa de ubicación',
            'google_maps' => 'Abrir en Google Maps',
            'viamichelin' => 'Abrir en ViaMichelin',
            'missing' => 'No hay coordenadas. Completa la dirección y usa "Actualizar desde dirección" en la sección Coordenadas.',
        ],
    ],
];
