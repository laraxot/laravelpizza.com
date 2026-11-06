<?php

declare(strict_types=1);

/**
 * Traducciones del componente de dirección (es).
 *
 * Usado por: AddressInput (módulo Geo), CreateTicketWizardWidget y dc-place-autocomplete (módulo Fixcity).
 * Espacio de nombres: geo::address.*
 * Sin este archivo el español caía en italiano ("Usa la tua posizione"), DCP-129.
 */
return [
    'fields' => [
        'use_my_location' => [
            'label' => 'Usar mi ubicación',
        ],
        'address' => [
            'label' => 'Lugar',
            'placeholder' => 'Busca un lugar',
            'use_my_location' => 'Usa tu ubicación',
        ],
    ],
    'geolocation' => [
        'locating' => 'Detectando tu ubicación...',
        'not_supported' => 'Tu navegador no admite la geolocalización.',
        'address_not_found' => 'No se ha encontrado la dirección.',
        'error' => 'Error durante la geolocalización.',
        'permission_denied' => 'Permiso de geolocalización denegado.',
        'timeout' => 'Se ha agotado el tiempo para detectar la ubicación.',
        'unavailable' => 'La ubicación no está disponible en este momento.',
    ],
    'validation' => [
        'required' => 'La dirección es obligatoria.',
        'max' => 'La dirección no puede superar los :max caracteres.',
    ],
];
