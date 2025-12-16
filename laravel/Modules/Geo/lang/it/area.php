<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome area',
            'placeholder' => 'Inserisci il nome dell\'area',
            'help' => 'Nome identificativo dell\'area',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione dettagliata dell\'area',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di area',
            'help' => 'Tipo di area geografica',
        ],
        'geometry' => [
            'label' => 'Geometria',
            'placeholder' => 'Inserisci la geometria',
            'help' => 'Geometria dell\'area in formato GeoJSON',
        ],
        'center_latitude' => [
            'label' => 'Latitudine centro',
            'placeholder' => 'Inserisci la latitudine del centro',
            'help' => 'Latitudine del centro dell\'area',
        ],
        'center_longitude' => [
            'label' => 'Longitudine centro',
            'placeholder' => 'Inserisci la longitudine del centro',
            'help' => 'Longitudine del centro dell\'area',
        ],
        'area_value' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie',
            'help' => 'Superficie dell\'area',
        ],
        'perimeter' => [
            'label' => 'Perimetro',
            'placeholder' => 'Inserisci il perimetro',
            'help' => 'Perimetro dell\'area',
        ],
        'is_active' => [
            'label' => 'Attiva',
            'help' => 'Indica se l\'area è attiva nel sistema',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome dell\'area è obbligatorio',
        'type_required' => 'Il tipo di area è obbligatorio',
        'geometry_required' => 'La geometria è obbligatoria',
        'geometry_invalid' => 'La geometria non è valida',
        'center_latitude_required' => 'La latitudine del centro è obbligatoria',
        'center_longitude_required' => 'La longitudine del centro è obbligatoria',
    ],
    'messages' => [
        'area_created' => 'Area creata con successo',
        'area_updated' => 'Area aggiornata con successo',
        'area_deleted' => 'Area eliminata con successo',
        'area_activated' => 'Area attivata con successo',
        'area_deactivated' => 'Area disattivata con successo',
        'geometry_imported' => 'Geometria importata con successo',
        'geometry_exported' => 'Geometria esportata con successo',
        'area_calculated' => 'Area calcolata con successo',
        'perimeter_calculated' => 'Perimetro calcolato con successo',
    ],
    'area_types' => [
        'administrative' => 'Amministrativa',
        'natural' => 'Naturale',
        'urban' => 'Urbana',
        'rural' => 'Rurale',
        'protected' => 'Protetta',
        'commercial' => 'Commerciale',
        'residential' => 'Residenziale',
        'industrial' => 'Industriale',
        'recreational' => 'Ricreativa',
        'custom' => 'Personalizzata',
    ],
    'area_units' => [
        'km2' => 'Chilometri quadrati',
        'm2' => 'Metri quadrati',
        'ha' => 'Ettari',
        'acres' => 'Acri',
        'sq_mi' => 'Miglia quadrate',
    ],
    'perimeter_units' => [
        'km' => 'Chilometri',
        'm' => 'Metri',
        'mi' => 'Miglia',
        'ft' => 'Piedi',
        'yd' => 'Iarde',
    ],
];
