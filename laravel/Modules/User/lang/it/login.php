<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Login',
        'plural_label' => 'Login',
        'group' => 'Autenticazione',
        'icon' => 'heroicon-o-arrow-right-on-rectangle',
        'sort' => 1,
    ],
    'label' => 'Login',
    'plural_label' => 'Login',
    'title' => 'Accedi al tuo account',
    'subtitle_start' => 'Oppure',
    'subtitle_link' => 'crea un nuovo account',
    'page' => [
        'title' => [
            'label' => 'Titolo Pagina',
            'tooltip' => 'Titolo della pagina di login',
            'helper_text' => 'Titolo principale della pagina',
            'description' => 'Benvenuto a LaravelPizza! 🍕',
        ],
        'subtitle' => [
            'label' => 'Sottotitolo Pagina',
            'tooltip' => 'Sottotitolo della pagina',
            'helper_text' => 'Sottotitolo descrittivo',
            'description' => 'Accedi alla community di developer e pizza lovers',
        ],
    ],
    'fields' => [
        'email' => [
            'label' => 'Email',
            'tooltip' => 'Indirizzo email',
            'placeholder' => 'Inserisci la tua email',
            'helper_text' => 'Inserisci il tuo indirizzo email',
            'description' => 'Indirizzo email dell\'utente',
        ],
        'password' => [
            'label' => 'Password',
            'tooltip' => 'Password di accesso',
            'placeholder' => 'Inserisci la tua password',
            'helper_text' => 'Inserisci la tua password',
            'description' => 'Password di accesso',
        ],
        'remember' => [
            'label' => 'Ricordami',
            'tooltip' => 'Mantieni l\'accesso',
            'placeholder' => 'Ricordami',
            'helper_text' => 'Rimani connesso',
            'description' => 'Opzione per rimanere loggato',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Accedi',
            'tooltip' => 'Accedi al sistema',
            'helper_text' => 'Effettua l\'accesso',
            'description' => 'Azione di login',
            'success' => 'Accesso effettuato con successo',
            'error' => 'Credenziali non valide',
        ],
        'register' => [
            'label' => 'Registrati',
            'tooltip' => 'Crea un nuovo account',
            'helper_text' => 'Registrati al sistema',
            'description' => 'Azione di registrazione',
            'success' => 'Registrazione completata con successo',
            'error' => 'Impossibile completare la registrazione',
        ],
        'forgot_password' => [
            'label' => 'Password dimenticata?',
            'tooltip' => 'Recupera la password',
            'helper_text' => 'Invia istruzioni per il recupero',
            'description' => 'Azione per password dimenticata',
            'success' => 'Istruzioni inviate alla tua email',
            'error' => 'Impossibile inviare le istruzioni',
        ],
        'hidePassword' => [
            'label' => 'Nascondi Password',
            'tooltip' => 'Nascondi la password',
            'helper_text' => 'Nasconde i caratteri della password',
            'description' => 'Toggle visibilità password',
            'icon' => 'heroicon-o-eye-slash',
        ],
        'showPassword' => [
            'label' => 'Mostra Password',
            'tooltip' => 'Mostra la password',
            'helper_text' => 'Mostra i caratteri della password',
            'description' => 'Toggle visibilità password',
            'icon' => 'heroicon-o-eye',
        ],
    ],
    'messages' => [
        'already_registered' => 'Non hai ancora un account?',
        'register' => 'Registrati',
        'no_account' => 'Non hai ancora un account?',
        'register_now' => 'Registrati ora',
        'forgot_password_text' => 'Hai dimenticato la tua password?',
        'reset_it' => 'Reimpostala qui',
    ],
];
