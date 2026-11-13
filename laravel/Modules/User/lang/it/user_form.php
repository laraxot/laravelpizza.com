<?php

declare(strict_types=1);

return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Mario',
            'helper_text' => 'Il tuo nome di battesimo',
            'description' => 'Nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Rossi',
            'helper_text' => 'Il tuo cognome',
            'description' => 'Cognome',
        ],
        'email' => [
            'label' => 'Indirizzo email',
            'placeholder' => 'mario.rossi@esempio.it',
            'helper_text' => 'Usa l\'indirizzo email che userai per accedere.',
            'description' => 'Email',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci una password sicura',
            'helper_text' => 'Minimo 12 caratteri, una maiuscola, una minuscola, un numero e un simbolo.',
            'description' => 'Password di accesso',
        ],
        'password_confirmation' => [
            'label' => 'Conferma password',
            'placeholder' => 'Ripeti la password',
            'helper_text' => 'Deve corrispondere alla password inserita sopra.',
            'description' => 'Conferma password',
        ],
        'remember' => [
            'label' => 'Ricordami',
            'description' => 'Mantieni la sessione attiva su questo dispositivo',
            'helper_text' => 'Sessione prolungata su dispositivo attendibile',
        ],
        'token' => [
            'label' => 'token',
        ],
    ],
    'actions' => [
        'showPassword' => [
            'label' => 'Mostra password',
            'icon' => 'heroicon-o-eye',
            'tooltip' => 'Mostra password',
        ],
        'hidePassword' => [
            'label' => 'Nascondi password',
            'icon' => 'heroicon-o-eye-slash',
            'tooltip' => 'Nascondi password',
        ],
    ],
<<<<<<< .merge_file_T3WJVU
    'sections' => [
        'empty' => [
            'heading' => '',
            'label' => '',
        ],
        'worker' => [
            'label' => 'worker',
            'heading' => 'worker',
        ],
    ],
=======
>>>>>>> .merge_file_iPwtsu
];
