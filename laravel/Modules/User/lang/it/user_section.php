<?php

declare(strict_types=1);

// Sezione "dati personali" del form utente (Filament/Forms/Components/UserSection).
return [
    'heading' => 'Dati personali',
    'fields' => [
        'ente' => [
            'label' => 'ente',
            'placeholder' => 'ente',
            'helper_text' => 'ente',
            'description' => 'ente',
        ],
        'matr' => [
            'label' => 'matr',
            'placeholder' => 'matr',
            'helper_text' => 'matr',
            'description' => 'matr',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'first_name',
            'helper_text' => 'first_name',
            'description' => 'first_name',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'last_name',
            'helper_text' => 'last_name',
            'description' => 'last_name',
        ],
        'email' => [
            'label' => 'E-mail',
            'placeholder' => 'email',
            'helper_text' => 'email',
            'description' => 'email',
        ],
    ],
];
