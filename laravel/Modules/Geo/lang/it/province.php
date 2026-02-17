<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome provincia',
            'placeholder' => 'Inserisci il nome della provincia',
            'help' => 'Nome ufficiale della provincia',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'code' => [
            'label' => 'Sigla',
            'placeholder' => 'Inserisci la sigla della provincia',
            'help' => 'Sigla della provincia (es. RM, MI, TO]',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'region' => [
            'label' => 'Regione',
            'placeholder' => 'Seleziona la regione',
            'help' => 'Regione di appartenenza',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Seleziona il paese',
            'help' => 'Paese di appartenenza',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'capital' => [
            'label' => 'Capoluogo',
            'placeholder' => 'Inserisci il capoluogo',
            'help' => 'Capoluogo della provincia',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'population' => [
            'label' => 'Popolazione',
            'placeholder' => 'Inserisci il numero di abitanti',
            'help' => 'Numero di abitanti della provincia',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'area' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie in km²',
            'help' => 'Superficie della provincia in chilometri quadrati',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Attiva',
            'help' => 'Indica se la provincia è attiva nel sistema',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome della provincia è obbligatorio',
        'code_required' => 'La sigla della provincia è obbligatoria',
        'code_unique' => 'La sigla della provincia deve essere unica',
        'region_required' => 'La regione è obbligatoria',
        'country_required' => 'Il paese è obbligatorio',
    ],
    'messages' => [
        'province_created' => 'Provincia creata con successo',
        'province_updated' => 'Provincia aggiornata con successo',
        'province_deleted' => 'Provincia eliminata con successo',
        'province_activated' => 'Provincia attivata con successo',
        'province_deactivated' => 'Provincia disattivata con successo',
    ],
    'label' => 'Province',
    'plural_label' => 'Province (Plurale)',
    'navigation' => [
        'name' => 'Province',
        'plural' => 'Province',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Province',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Province',
        ],
        'edit' => [
            'label' => 'Modifica Province',
        ],
        'delete' => [
            'label' => 'Elimina Province',
        ],
    ],
];
