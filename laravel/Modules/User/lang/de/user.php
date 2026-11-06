<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Utenti',
        'plural' => 'Utenti',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione degli utenti e dei loro permessi',
        ],
        'label' => 'Utenti',
        'sort' => '26',
        'icon' => 'user-main',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'description' => 'name',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'description' => 'email',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'description' => 'password',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la password',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'current_password' => [
            'label' => 'Password Attuale',
            'placeholder' => 'Inserisci la password attuale',
        ],
        'status' => [
            'label' => 'Stato',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'blocked' => 'Bloccato',
            ],
        ],
    ],
    'actions' => [
        'create' => 'Crea Utente',
        'edit' => 'Modifica Utente',
        'delete' => 'Elimina Utente',
        'impersonate' => 'Impersona Utente',
        'stop_impersonating' => 'Termina Impersonificazione',
        'block' => 'Blocca',
        'unblock' => 'Sblocca',
        'send_reset_link' => 'Invia Link Reset Password',
        'verify_email' => 'Verifica Email',
        'attach_role' => 'Rolle zuweisen',
    ],
    'messages' => [
        'created' => 'Utente creato con successo',
        'updated' => 'Utente aggiornato con successo',
        'deleted' => 'Utente eliminato con successo',
        'blocked' => 'Utente bloccato con successo',
        'unblocked' => 'Utente sbloccato con successo',
        'reset_link_sent' => 'Link per il reset della password inviato',
        'email_verified' => 'Email verificata con successo',
        'impersonating' => 'Stai impersonando l\'utente :name',
        'credentials_incorrect' => 'Die angegebenen Anmeldedaten sind nicht korrekt',
        'login_success' => 'Anmeldung erfolgreich',
        'validation_error' => 'Validierungsfehler',
        'login_error' => 'Bei der Anmeldung ist ein Fehler aufgetreten. Versuchen Sie es später erneut',
    ],
    'validation' => [
        'email_unique' => 'Questa email è già in uso',
        'password_min' => 'La password deve essere di almeno :min caratteri',
        'password_confirmed' => 'Le password non coincidono',
        'current_password' => 'La password attuale non è corretta',
    ],
    'permissions' => [
        'view_users' => 'Visualizza utenti',
        'create_users' => 'Crea utenti',
        'edit_users' => 'Modifica utenti',
        'delete_users' => 'Elimina utenti',
        'impersonate_users' => 'Impersona utenti',
        'manage_roles' => 'Gestisci ruoli',
    ],
    'model' => [
        'label' => 'Utente',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
