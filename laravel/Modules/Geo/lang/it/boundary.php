<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome confine',
            'placeholder' => 'Inserisci il nome del confine',
            'help' => 'Nome identificativo del confine',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione dettagliata del confine',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di confine',
            'help' => 'Tipo di confine amministrativo',
        ],
        'level' => [
            'label' => 'Livello',
            'placeholder' => 'Seleziona il livello',
            'help' => 'Livello amministrativo del confine',
        ],
        'parent_boundary' => [
            'label' => 'Confine padre',
            'placeholder' => 'Seleziona il confine padre',
            'help' => 'Confine amministrativo superiore',
        ],
        'geometry' => [
            'label' => 'Geometria',
            'placeholder' => 'Inserisci la geometria',
            'help' => 'Geometria del confine in formato GeoJSON',
        ],
        'area' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie in km²',
            'help' => 'Superficie del confine in chilometri quadrati',
        ],
        'perimeter' => [
            'label' => 'Perimetro',
            'placeholder' => 'Inserisci il perimetro in km',
            'help' => 'Perimetro del confine in chilometri',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Indica se il confine è attivo nel sistema',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome del confine è obbligatorio',
        'type_required' => 'Il tipo di confine è obbligatorio',
        'level_required' => 'Il livello è obbligatorio',
        'geometry_required' => 'La geometria è obbligatoria',
        'geometry_invalid' => 'La geometria non è valida',
    ],
    'messages' => [
        'boundary_created' => 'Confine creato con successo',
        'boundary_updated' => 'Confine aggiornato con successo',
        'boundary_deleted' => 'Confine eliminato con successo',
        'boundary_activated' => 'Confine attivato con successo',
        'boundary_deactivated' => 'Confine disattivato con successo',
        'geometry_imported' => 'Geometria importata con successo',
        'geometry_exported' => 'Geometria esportata con successo',
    ],
    'boundary_types' => [
        'country' => 'Paese',
        'region' => 'Regione',
        'province' => 'Provincia',
        'municipality' => 'Comune',
        'district' => 'Distretto',
        'neighborhood' => 'Quartiere',
        'postal_code' => 'CAP',
        'electoral' => 'Elettorale',
        'custom' => 'Personalizzato',
    ],
    'boundary_levels' => [
        '0' => 'Paese',
        '1' => 'Regione',
        '2' => 'Provincia',
        '3' => 'Comune',
        '4' => 'Distretto',
        '5' => 'Quartiere',
        '6' => 'CAP',
        '7' => 'Personalizzato',
    ],
];
