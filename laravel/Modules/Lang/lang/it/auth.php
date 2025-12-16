<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Authentication Language Lines
     * |--------------------------------------------------------------------------
     * |
     * | The following language lines are used during authentication for various
     * | messages that we need to display to the user. You are free to modify
     * | these language lines according to your application's requirements.
     * |
     */

    'failed' => 'Credenziali non valide.',
    'password' => 'La password fornita non è corretta.',
    'throttle' => 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
    'login' => [
        'title' => 'Accedi',
        'email' => 'Email',
        'password' => 'Password',
        'remember_me' => 'Ricordami',
        'forgot_password' => 'Password dimenticata?',
        'submit' => 'Accedi',
        'or' => 'oppure',
        'create_account' => 'crea un nuovo account',
        'link' => 'Accedi',
    ],
    'register' => [
        'title' => 'Registati',
        'name' => 'Nome',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Conferma Password',
        'submit' => 'Registrati',
        'already_registered' => 'Hai già un account?',
        'link' => 'Registrati',
    ],
    'verify' => [
        'title' => 'Verifica il tuo indirizzo email',
        'success' => 'Un nuovo link di verifica è stato inviato al tuo indirizzo email.',
        'notice' => 'Prima di procedere, controlla la tua email per un link di verifica. Se non hai ricevuto l\'email,',
        'another_request' => 'clicca qui per richiederne un\'altra',
    ],
    'forgot_password' => [
        'title' => 'Password dimenticata',
        'email' => 'Email',
        'submit' => 'Invia link di reset',
    ],
    'reset_password' => [
        'title' => 'Reimposta la password',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Conferma Password',
        'submit' => 'Reimposta Password',
    ],
    'confirm_password' => [
        'title' => 'Conferma la password',
        'password' => 'Password',
        'submit' => 'Conferma',
    ],
    'logout' => [
        'submit' => 'Logout',
        'title' => 'Logout',
        'success_title' => 'Logout effettuato',
        'success_message' => 'Sei stato disconnesso con successo.',
        'error_title' => 'Errore durante il logout',
        'error_message' => 'Si è verificato un errore durante il logout. Riprova.',
        'confirm_message' => 'Sei sicuro di voler effettuare il logout?',
        'confirm_button' => 'Conferma logout',
        'cancel_button' => 'Annulla',
        'back_to_home' => 'Torna alla home',
        'try_again' => 'Riprova',
        'processing' => 'Disconnessione in corso...',
    ],
    'user_dropdown' => [
        'manage_account' => 'Gestisci Account',
        'profile' => 'Profilo',
        'settings' => 'Impostazioni',
        'logout' => 'Disconnetti',
    ],
];
