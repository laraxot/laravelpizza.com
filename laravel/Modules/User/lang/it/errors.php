<?php

declare(strict_types=1);

return [
    'passwords' => [
        'user' => [
            'label' => 'Non riusciamo a trovare un utente con questo indirizzo email.',
            'title' => 'Utente non trovato',
            'description' => 'Verifica che l\'indirizzo email sia corretto e riprova.',
        ],
        'token' => [
            'label' => 'Il token di reset password non è valido o è scaduto.',
            'title' => 'Token non valido',
            'description' => 'Il link di reset potrebbe essere scaduto. Richiedi un nuovo link.',
        ],
        'sent' => [
            'label' => 'Ti abbiamo inviato il link per reimpostare la password!',
            'title' => 'Link inviato',
            'description' => 'Controlla la tua casella di posta elettronica.',
        ],
        'reset' => [
            'label' => 'La tua password è stata reimpostata con successo!',
            'title' => 'Password reimpostata',
            'description' => 'Ora puoi accedere con la nuova password.',
        ],
        'throttled' => [
            'label' => 'Troppi tentativi di reset. Per favore attendi prima di riprovare.',
            'title' => 'Troppi tentativi',
            'description' => 'Attendi qualche minuto prima di richiedere un nuovo link.',
        ],
    ],
    'auth' => [
        'failed' => [
            'label' => 'Credenziali non valide.',
            'title' => 'Accesso negato',
            'description' => 'Email o password non corretti.',
        ],
        'throttle' => [
            'label' => 'Troppi tentativi di accesso. Riprova fra :seconds secondi.',
            'title' => 'Account temporaneamente bloccato',
            'description' => 'Per sicurezza, attendi prima di riprovare.',
        ],
        'unauthorized' => [
            'label' => 'Non hai i permessi necessari per questa operazione.',
            'title' => 'Accesso non autorizzato',
            'description' => 'Contatta l\'amministratore se pensi che questo sia un errore.',
        ],
    ],
    'validation' => [
        'required' => [
            'label' => 'Il campo :attribute è obbligatorio.',
            'title' => 'Campo obbligatorio',
            'description' => 'Compila tutti i campi richiesti per continuare.',
        ],
        'email' => [
            'label' => 'Il campo :attribute deve essere un indirizzo email valido.',
            'title' => 'Email non valida',
            'description' => 'Inserisci un indirizzo email nel formato corretto.',
        ],
        'min' => [
            'label' => 'Il campo :attribute deve avere almeno :min caratteri.',
            'title' => 'Lunghezza insufficiente',
            'description' => 'Il valore inserito è troppo corto.',
        ],
    ],
    'navigation' => [],
    'label' => '',
    'plural_label' => '',
    'fields' => [],
    'actions' => [],
];
