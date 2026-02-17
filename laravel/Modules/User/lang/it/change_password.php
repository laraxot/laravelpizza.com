<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Cambia Password',
        'plural_label' => 'Cambia Password',
        'group' => 'Impostazioni',
        'icon' => 'heroicon-o-lock-closed',
        'sort' => 10,
    ],
    'label' => 'Cambia Password',
    'plural_label' => 'Cambia Password',
    'fields' => [
        'current_password' => [
            'label' => 'Password Attuale',
            'tooltip' => 'Inserisci la password attuale',
            'placeholder' => 'Inserisci la password attuale',
            'helper_text' => 'La tua password attuale per verificare l\'identità',
            'description' => 'Password corrente dell\'utente',
        ],
        'new_password' => [
            'label' => 'Nuova Password',
            'tooltip' => 'Inserisci la nuova password',
            'placeholder' => 'Inserisci la nuova password',
            'helper_text' => 'Minimo 8 caratteri con lettere e numeri',
            'description' => 'Nuova password da impostare',
        ],
        'new_password_confirmation' => [
            'label' => 'Conferma Nuova Password',
            'tooltip' => 'Reinserisci la nuova password',
            'placeholder' => 'Reinserisci la nuova password',
            'helper_text' => 'Devi inserire la stessa password per conferma',
            'description' => 'Conferma della nuova password',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva Password',
            'tooltip' => 'Salva la nuova password',
            'helper_text' => 'Aggiorna la password',
            'description' => 'Azione per salvare la nuova password',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'tooltip' => 'Annulla l\'operazione',
            'helper_text' => 'Torna indietro senza salvare',
            'description' => 'Azione per annullare',
        ],
    ],
    'messages' => [
        'password_changed' => 'Password cambiata con successo',
        'password_mismatch' => 'Le password non coincidono',
        'current_password_wrong' => 'La password attuale non è corretta',
        'error' => 'Si è verificato un errore',
    ],
];
