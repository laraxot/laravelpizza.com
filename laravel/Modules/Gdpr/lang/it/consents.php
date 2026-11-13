<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
        'treatment' => [
            'name' => [
                'label' => 'Trattamento',
            ],
        ],
        'subject_id' => [
            'label' => 'Soggetto',
        ],
        'accepted_at' => [
            'label' => 'Accettato il',
        ],
        'revoked_at' => [
            'label' => 'Revocato il',
        ],
    ],
    'actions' => [
        'delete' => [
            'tooltip' => '',
            'icon' => 'delete',
        ],
    ],
];
