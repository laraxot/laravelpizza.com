<?php

declare(strict_types=1);

// Scheda di dettaglio di un voto (`RatingMorphInfolist`, chiave `rating::rating_morph_infolist`).
// Stesse etichette della lista (`rating_morphs.php`): un voto si chiama uguale ovunque.
return [
    'fields' => [
        'model_id' => ['label' => 'ID elemento valutato'],
        'model_type' => ['label' => 'Tipo elemento valutato'],
        'rating_id' => ['label' => 'ID criterio'],
        'user_id' => ['label' => 'ID utente'],
        'note' => ['label' => 'Nota'],
        'value' => ['label' => 'Voto'],
        'is_winner' => ['label' => 'Vincente'],
        'reward' => ['label' => 'Premio'],
    ],
];
