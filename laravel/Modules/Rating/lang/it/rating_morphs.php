<?php

declare(strict_types=1);

// Colonne e azioni della lista dei voti (`RatingMorphsTable`, chiave `rating::rating_morphs`).
// Un `rating_morph` e' il voto di un utente (`user_id`) su un criterio (`rating_id`) per un elemento
// valutato (`model_type` + `model_id`). Vedi `Modules/Rating/docs/wiki/concepts/xotbase-table-columns-enforcement.md`.
return [
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'rating_id' => [
            'label' => 'ID criterio',
        ],
        'user_id' => [
            'label' => 'ID utente',
        ],
        'model_type' => [
            'label' => 'Tipo elemento valutato',
        ],
        'model_id' => [
            'label' => 'ID elemento valutato',
        ],
        'value' => [
            'label' => 'Voto',
        ],
        'note' => [
            'label' => 'Nota',
        ],
        'is_winner' => [
            'label' => 'Vincente',
        ],
        'reward' => [
            'label' => 'Premio',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
        'rating' => [
            'label' => 'Criterio',
            'title' => [
                'label' => 'Titolo criterio',
            ],
        ],
        'ratingable_type' => [
            'label' => 'Tipo elemento valutato',
        ],
        'ratingable_id' => [
            'label' => 'ID elemento valutato',
        ],
    ],
    'actions' => [
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'delete',
            'tooltip' => 'Elimina',
        ],
        'create' => [
            'label' => 'Nuovo voto',
            'icon' => 'create',
            'tooltip' => 'Nuovo voto',
        ],
        'layout' => [
            'label' => 'Layout',
            'icon' => 'layout',
            'tooltip' => 'Layout',
        ],
        'view' => [
            'label' => 'Vedi',
            'icon' => 'view',
            'tooltip' => 'Vedi',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'edit',
            'tooltip' => 'Modifica',
        ],
    ],
];
