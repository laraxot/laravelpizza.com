<?php

declare(strict_types=1);

return [
    'region' => [
        'label' => 'Regione',
        'placeholder' => 'Seleziona una regione',
        'help' => 'Scegli la regione di interesse',
    ],
    'province' => [
        'label' => 'Provincia',
        'placeholder' => 'Seleziona una provincia',
        'help' => 'Prima seleziona una regione',
    ],
    'cap' => [
        'label' => 'CAP',
        'placeholder' => 'Seleziona un CAP',
        'help' => 'Prima seleziona regione e provincia',
    ],
    'administrative_area_level_3' => [
        'label' => 'Comune',
        'description' => 'Comune di appartenza',
        'icon' => 'heroicon-o-building-office',
        'color' => 'primary',
    ],
    'administrative_area_level_2' => [
        'label' => 'Provincia',
        'description' => 'Provincia di appartenza',
        'icon' => 'heroicon-o-map-pin',
        'color' => 'danger',
    ],
    'administrative_area_level_1' => [
        'label' => 'Regione',
        'description' => 'Regione di appartenza',
        'icon' => 'heroicon-o-globe-alt',
        'color' => 'purple',
    ],
    'validation' => [
        'region_required_for_province' => 'Devi selezionare una regione prima di scegliere la provincia',
        'region_province_required_for_cap' => 'Devi selezionare regione e provincia prima di scegliere il CAP',
    ],
    'label' => 'Location Selector',
    'plural_label' => 'Location Selector (Plurale)',
    'navigation' => [
        'name' => 'Location Selector',
        'plural' => 'Location Selector',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Location Selector',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Location Selector',
        ],
        'edit' => [
            'label' => 'Modifica Location Selector',
        ],
        'delete' => [
            'label' => 'Elimina Location Selector',
        ],
    ],
];
