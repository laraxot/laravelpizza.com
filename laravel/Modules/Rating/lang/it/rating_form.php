<?php

declare(strict_types=1);

return [
    'fields' => [
        'extra_attributes' => [
            'type' => ['label' => 'extra_attributes.type', 'placeholder' => 'extra_attributes.type', 'helper_text' => 'extra_attributes.type', 'description' => 'extra_attributes.type'],
            'anno' => ['label' => 'extra_attributes.anno', 'placeholder' => 'extra_attributes.anno', 'helper_text' => 'extra_attributes.anno', 'description' => 'extra_attributes.anno'],
        ],
        'title' => ['label' => 'Titolo', 'placeholder' => 'Titolo del criterio', 'helper_text' => '', 'description' => 'Nome con cui il criterio compare nelle valutazioni'],
        'color' => ['label' => 'Colore', 'placeholder' => 'Scegli un colore', 'helper_text' => '', 'description' => 'Colore del criterio'],
        'rule' => ['label' => 'Regola', 'placeholder' => 'Scegli la regola', 'helper_text' => '', 'description' => 'Intervallo di voti ammessi per il criterio'],
        'is_disabled' => ['label' => 'Disattivato', 'placeholder' => 'Disattivato', 'helper_text' => '', 'description' => 'Un criterio disattivato non e\' piu\' proposto nelle valutazioni'],
        'is_readonly' => ['label' => 'Sola lettura', 'placeholder' => 'Sola lettura', 'helper_text' => '', 'description' => 'Un criterio in sola lettura mostra i voti ma non li accetta'],
        'txt' => ['label' => 'Testo', 'placeholder' => 'Descrizione del criterio', 'helper_text' => '', 'description' => 'Descrizione estesa del criterio'],
        'parent_id' => ['label' => 'Criterio padre', 'placeholder' => 'Nessun criterio padre', 'helper_text' => '', 'description' => 'Criterio di livello superiore, se esiste'],
    ],
    'sections' => [
        'empty' => ['label' => 'empty', 'heading' => 'empty'],
    ],
];
