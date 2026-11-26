<?php

declare(strict_types=1);

return [
    'state' => [
        'not_rated' => 'non valutata (:count criteri)',
        'rated' => ':count criteri · totale :total',
    ],
    'fields' => [
        'ratings' => [
            'label' => 'Valutazione',
        ],
        'ratings_state' => [
            'label' => 'Stato valutazione',
        ],
        'ratings_count' => [
            'label' => 'Criteri',
        ],
        'ratings_sum_value' => [
            'label' => 'Totale punteggio',
        ],
        'has_rating_values' => [
            'label' => 'Valutazione inserita',
            'placeholder' => 'Tutte',
            'true' => 'Solo valutate',
            'false' => 'Solo non valutate',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'title' => [
            'label' => 'Titolo',
        ],
        'slug' => [
            'label' => 'Indirizzo (slug)',
        ],
        'rule' => [
            'label' => 'Regola',
        ],
        'is_disabled' => [
            'label' => 'Disattivato',
        ],
        'is_readonly' => [
            'label' => 'Sola lettura',
        ],
        'order_column' => [
            'label' => 'Ordine',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
    ],
    'actions' => [
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'delete',
            'tooltip' => '',
        ],
        'view' => [
            'label' => 'Vista',
            'icon' => 'view',
            'tooltip' => '',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'edit',
            'tooltip' => '',
        ],
        'layout' => [
            'tooltip' => '',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'create' => [
            'label' => 'create',
        ],
    ],
];
