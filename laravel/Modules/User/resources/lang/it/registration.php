<?php

declare(strict_types=1);

return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome',
            'tooltip' => 'Inserisci il tuo nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il tuo cognome',
            'tooltip' => 'Inserisci il tuo cognome',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email',
            'tooltip' => 'Inserisci un indirizzo email valido',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il tuo numero di telefono',
            'tooltip' => 'Inserisci un numero di telefono valido',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci il tuo indirizzo',
            'tooltip' => 'Inserisci il tuo indirizzo di residenza',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la tua città',
            'tooltip' => 'Inserisci la città di residenza',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP',
            'tooltip' => 'Inserisci il Codice di Avviamento Postale',
        ],
        'province' => [
            'label' => 'Provincia',
            'placeholder' => 'Inserisci la provincia',
            'tooltip' => 'Inserisci la provincia di residenza',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Inserisci il paese',
            'tooltip' => 'Inserisci il paese di residenza',
            'default' => 'Italia',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la tua password',
            'tooltip' => 'La password deve essere di almeno 8 caratteri',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la tua password',
            'tooltip' => 'Inserisci nuovamente la password per conferma',
        ],
        'terms' => [
            'label' => 'Accetto i termini e le condizioni',
            'tooltip' => 'Devi accettare i termini e le condizioni per procedere',
        ],
        'newsletter' => [
            'label' => 'Iscriviti alla newsletter',
            'tooltip' => 'Ricevi aggiornamenti e novità via email',
        ],
    ],
    'buttons' => [
        'register' => 'Registrati',
        'next' => 'Avanti',
        'back' => 'Indietro',
        'complete' => 'Completa Registrazione',
    ],
    'messages' => [
        'success' => 'Registrazione completata con successo!',
        'error' => 'Si è verificato un errore durante la registrazione.',
        'validation_error' => 'Compila tutti i campi obbligatori per procedere.',
    ],
    'steps' => [
        'personal_data' => [
            'title' => 'Dati Anagrafici',
            'description' => 'Inserisci i tuoi dati personali',
        ],
        'contacts' => [
            'title' => 'Contatti e Indirizzo',
            'description' => 'Inserisci i tuoi contatti e l\'indirizzo',
        ],
        'isee' => [
            'title' => 'Dati ISEE',
            'description' => 'Inserisci i dati ISEE (opzionale)',
        ],
        'confirmation' => [
            'title' => 'Conferma Dati',
            'description' => 'Verifica i dati inseriti prima di completare la registrazione',
        ],
    ],
];
