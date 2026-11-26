<?php

declare(strict_types=1);

// Form di creazione/modifica di un voto (`RatingMorphForm`, chiave `rating::rating_morph_form`).
// Niente `percentage`: e' calcolata, non si inserisce. Vedi
// `Modules/Rating/docs/wiki/concepts/xotbase-table-columns-enforcement.md`.
return [
    'fields' => [
        'rating_id' => [
            'label' => 'Criterio',
            'placeholder' => 'Seleziona il criterio',
            'helper_text' => 'Il criterio di valutazione a cui si riferisce il voto',
            'description' => 'Criterio di valutazione del voto',
        ],
        'value' => [
            'label' => 'Voto',
            'placeholder' => 'Inserisci il voto',
            'helper_text' => '',
            'description' => 'Valore numerico del voto',
        ],
        'note' => [
            'label' => 'Nota',
            'placeholder' => 'Aggiungi una nota (facoltativa)',
            'helper_text' => '',
            'description' => 'Commento che accompagna il voto',
        ],
    ],
];
