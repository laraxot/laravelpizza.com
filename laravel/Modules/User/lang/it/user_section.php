<?php

declare(strict_types=1);

// Sezione "dati personali" del form utente (Filament/Forms/Components/UserSection).
return [
    'heading' => 'Dati personali',
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
        ],
        'email' => [
            'label' => 'Email',
        ],
    ],
];
