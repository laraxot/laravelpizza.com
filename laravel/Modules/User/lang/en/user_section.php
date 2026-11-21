<?php

declare(strict_types=1);

// Sezione "dati personali" del form utente (Filament/Forms/Components/UserSection).
return [
    'heading' => 'Personal details',
    'fields' => [
        'first_name' => [
            'label' => 'First name',
        ],
        'last_name' => [
            'label' => 'Last name',
        ],
        'email' => [
            'label' => 'Email',
        ],
    ],
];
