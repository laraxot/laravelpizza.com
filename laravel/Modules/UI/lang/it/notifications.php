<?php

declare(strict_types=1);

return [
    'state_transition' => [
        'success' => [
            'title' => 'Transizione Completata',
            'body' => 'Lo stato è stato cambiato a ":state" con successo.',
        ],
        'error' => [
            'title' => 'Errore Transizione',
            'body' => 'Si è verificato un errore durante la transizione di stato: :error',
        ],
    ],
];
