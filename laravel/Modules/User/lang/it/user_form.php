<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome visualizzato',
<<<<<<< HEAD
            'placeholder' => 'Inserisci il nome visualizzato',
            'helper_text' => 'Il nome mostrato nel sito e nei pannelli.',
            'description' => 'Nome visualizzato',
=======
            'helper_text' => 'Il nome mostrato nel sito e nei pannelli.',
            'placeholder' => 'name',
            'description' => 'name',
>>>>>>> laraxot/dev
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
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
<<<<<<< HEAD
            'placeholder' => '',
        ],
        'token' => [
            'label' => 'Token',
            'description' => 'Token di sicurezza',
            'helper_text' => 'Token usato per la verifica o il reset',
            'placeholder' => 'Incolla il token',
        ],
        'state' => [
            'label' => 'Stato',
            'description' => 'Stato corrente',
            'placeholder' => 'Seleziona lo stato',
            'helper_text' => 'Stato del record',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'helper_text' => 'Tipo di utente o record',
            'description' => 'Tipo',
=======
            'placeholder' => 'remember',
        ],
        'token' => [
            'label' => 'Token',
            'description' => 'token',
            'helper_text' => 'token',
            'placeholder' => 'token',
        ],
        'state' => [
            'description' => 'state',
            'label' => 'Stato',
            'placeholder' => 'state',
            'helper_text' => 'state',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'type',
            'helper_text' => 'type',
            'description' => 'type',
        ],
        'roles' => [
            'label' => 'roles',
        ],
        'is_active' => [
            'label' => 'is_active',
        ],
        'updated_at' => [
            'label' => 'updated_at',
>>>>>>> laraxot/dev
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
    'sections' => [
        'empty' => [
            'heading' => '',
            'label' => '',
        ],
        'worker' => [
<<<<<<< HEAD
            'label' => 'Lavoratore',
            'heading' => 'Lavoratore',
=======
            'label' => 'worker',
            'heading' => 'worker',
>>>>>>> laraxot/dev
        ],
    ],
];
