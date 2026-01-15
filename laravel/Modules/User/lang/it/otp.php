<?php

declare(strict_types=1);

return [
    'otp_code' => 'Codice OTP',
    'title' => 'Password Scaduta, Reimposta Password',
    'heading' => 'Crea una Nuova Password',
    'sub_heading' => 'La tua password è scaduta, per favore crea una nuova password',
    'form' => [
        'current_password' => [
            'label' => 'Password Attuale',
            'validation_attribute' => 'password_attuale',
        ],
        'password' => [
            'label' => 'Nuova Password',
            'validation_attribute' => 'password',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
        ],
    ],
    'fields' => [
        'current_password' => [
            'label' => 'Password Attuale',
            'validation_attribute' => 'password_attuale',
        ],
        'password' => [
            'label' => 'Nuova Password',
            'validation_attribute' => 'password',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
        ],
    ],
    'reset_password' => 'Reimposta Password',
    'password_reset' => 'Password Reimpostata',
    'mail' => [
        'subject' => 'Codice OTP',
        'greeting' => 'Ciao!',
        'line1' => 'Il tuo codice OTP è: :code',
        'line2' => 'Questo codice sarà valido per :minutes minuti.',
        'line3' => 'Se non hai richiesto un codice, ignora questa email.',
        'salutation' => 'Cordiali saluti, :app_name',
    ],
    'view' => [
        'time_left' => 'secondi rimasti',
        'resend_code' => 'Invia nuovamente il codice',
        'verify' => 'Verifica',
        'go_back' => 'Torna Indietro',
    ],
    'notifications' => [
        'title' => 'Codice OTP Inviato',
        'body' => 'Il codice di verifica è stato inviato al tuo indirizzo email. Sarà valido per :seconds secondi.',
        'wrong_password' => [
            'title' => 'Password Errata',
            'body' => 'La password attuale inserita non è corretta.',
        ],
        'column_not_found' => [
            'title' => 'Colonna Non Trovata',
            'body' => 'La colonna ":column_name" o la colonna della password ":password_column_name" non è stata trovata nella tabella :table_name.',
        ],
        'password_reset' => [
            'success' => 'Password Reimpostata con Successo',
        ],
        'same_password' => [
            'title' => 'Password Uguale',
            'body' => 'La nuova password deve essere diversa dalla password attuale.',
        ],
        'otp_expired' => [
            'title' => 'Otp Scaduto',
            'body' => 'Il codice OTP utilizzato non è più valido. Contatta l\'assistenza per ottenere un nuovo codice OTP',
        ],
    ],
    'exceptions' => [
        'column_not_found' => 'La colonna ":column_name" o la colonna della password ":password_column_name" non è stata trovata nella tabella ":table_name". Pubblica le migrazioni e eseguile, se l\'errore persiste, pubblica il file di configurazione e aggiorna i valori di table_name, column_name, e password_column_name.',
    ],
    'validation' => [
        'invalid_code' => 'Il codice inserito non è valido.',
        'expired_code' => 'Il codice inserito è scaduto.',
    ],
    'actions' => [
        'send_otp' => 'Invia Codice OTP',
        'yes_send_otp' => 'Si, Invia Codice OTP',
        'confirm_otp' => 'Sei sicuro di voler inviare una password temporanea a questo utente? Sarà richiesto di cambiarla al primo accesso.',
        'send_otp_success' => 'Password temporanea inviata con successo.',
    ],
    'navigation' => [
        'name' => 'OTP',
        'plural' => 'OTPs',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione delle password usa e getta',
        ],
        'label' => 'otp',
        'sort' => 31,
        'icon' => 'user-user-otp',
    ],
    'label' => '',
    'plural_label' => '',
];
