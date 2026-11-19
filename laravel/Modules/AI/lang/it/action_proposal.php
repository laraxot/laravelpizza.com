<?php

declare(strict_types=1);

return [
    'label' => 'Proposta di azione AI',
    'plural_label' => 'Proposte di azione AI',
    'navigation_group' => 'Assistente AI',
    'fields' => [
        'section' => [
            'label' => 'Dettagli proposta',
        ],
        'thread' => [
            'label' => 'Conversazione',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'preview' => [
            'label' => 'Anteprima',
        ],
        'error' => [
            'label' => 'Errore',
        ],
        'confirmed_at' => [
            'label' => 'Confermata il',
        ],
        'executed_at' => [
            'label' => 'Eseguita il',
        ],
    ],
    'statuses' => [
        'pending' => 'In attesa',
        'cancelled' => 'Annullata',
        'confirmed' => 'Confermata',
        'executed' => 'Eseguita',
        'failed' => 'Fallita',
    ],
    'actions' => [
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
    ],
];
