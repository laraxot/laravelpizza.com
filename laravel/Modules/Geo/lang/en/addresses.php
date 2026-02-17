<?php

declare(strict_types=1);

return [
    'field' => [
        'label' => 'Indirizzi',
        'help' => [
            'title' => 'Gestione Indirizzi',
            'description' => 'Puoi aggiungere più indirizzi. Con più indirizzi potrai specificare un nome identificativo e designare uno come principale.',
            'primary_note' => 'Solo un indirizzo può essere impostato come principale alla volta.',
        ],
        'actions' => [
            'add' => 'Aggiungi Indirizzo',
            'remove' => 'Rimuovi Indirizzo',
            'move_up' => 'Sposta Su',
            'move_down' => 'Sposta Giù',
        ],
        'empty_state' => [
            'title' => 'Nessun indirizzo configurato',
            'description' => 'Inizia aggiungendo il primo indirizzo.',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome Indirizzo',
            'placeholder' => 'es. Sede Principale, Filiale Nord, Casa',
            'help' => 'Nome identificativo per questo indirizzo (visibile solo con più indirizzi)',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_primary' => [
            'label' => 'Indirizzo Principale',
            'help' => 'Designa questo come indirizzo principale (solo uno può essere principale)',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'messages' => [
        'validation' => [
            'min_items' => 'È richiesto almeno :min indirizzo/i.',
            'max_items' => 'Non è possibile avere più di :max indirizzi.',
            'primary_required' => 'Almeno un indirizzo deve essere designato come principale.',
        ],
        'success' => [
            'added' => 'Indirizzo aggiunto con successo.',
            'updated' => 'Indirizzi aggiornati con successo.',
            'removed' => 'Indirizzo rimosso con successo.',
            'primary_set' => 'Indirizzo principale aggiornato.',
        ],
    ],
    'tooltips' => [
        'name_visibility' => 'Il campo nome è visibile solo quando hai più di un indirizzo',
        'primary_exclusivity' => 'Impostando questo come principale, tutti gli altri diventeranno secondari',
        'single_primary' => 'Con un solo indirizzo, questo è automaticamente il principale',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
