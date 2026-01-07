<?php

declare(strict_types=1);

return [
    'login-via' => 'Accedi con',
    'login-failed' => 'Login fallito, riprova.',
    'user-not-allowed' => 'La tua email non è autorizzata.',
    'registration-not-enabled' => 'Non è possibile registrare un nuovo utente.',
    'Sign in to your account' => 'Accedi al tuo account',
    'create a new account' => 'Crea un nuovo account',
    'Or' => 'O',
    'Email address' => 'Indirizzo e-mail',
    'Password' => 'Password',
    'Remember me' => 'Ricordami',
    'Remember' => 'Ricordami',
    'Forgot your password?' => 'Password dimenticata?',
    'Sign in' => 'Accedi',
    'login-in' => 'Accedi',
    'sign-up' => 'Registrati',
    'password_expired' => [
        'title' => 'Password Scaduta, Reimposta Password',
        'heading' => 'Crea una Nuova Password',
        'sub_heading' => 'La tua password è scaduta, per favore crea una nuova password',
        'fields' => [
            'current_password' => [
                'label' => 'Current Password',
                'validation_attribute' => 'current_password',
            ],
            'password' => [
                'label' => 'Password',
                'validation_attribute' => 'password',
            ],
            'password_confirmation' => [
                'label' => 'Confirm Password',
            ],
        ],
        'form' => [
            'current_password' => [
                'label' => 'Current Password',
                'validation_attribute' => 'current_password',
            ],
            'password' => [
                'label' => 'Password',
                'validation_attribute' => 'password',
            ],
            'password_confirmation' => [
                'label' => 'Confirm Password',
            ],
        ],
        'actions' => [
            'reset_password' => ['label' => 'Reset Password'],
            'cancel' => ['label' => 'Cancel'],
        ],
        'reset_password' => 'Reset Password',
        'password_reset' => 'Password Reset',
        'notifications' => [
            'wrong_password' => [
                'title' => 'Wrong Password',
                'body' => 'The current password you entered is incorrect.',
            ],
            'column_not_found' => [
                'title' => 'Column Not Found',
                'body' => 'Either the column ":column_name" or the password column ":password_column_name" was not found in the :table_name table.',
            ],
            'password_reset' => [
                'success' => 'Password Reset Successful',
            ],
            'same_password' => [
                'title' => 'Same Password',
                'body' => 'The new password must be different from the current password.',
            ],
        ],
        'exceptions' => [
            'column_not_found' => 'Either the column ":column_name" or the password column ":password_column_name" was not found in the ":table_name" table. Please publish migrations and run them, if the error still persists, publish the config file and update the table_name, column_name, and password_column_name values.',
        ],
    ],
    'failed' => 'Le credenziali non corrispondono a quelle registrate.',
    'general_error' => 'Non hai diritti sufficienti per questa operazione.',
    'socialite' => [
        'unacceptable' => ':provider non è supportato.',
    ],
    'throttle' => 'Troppi tentativi di login. Si prega di riprovare tra :seconds secondi.',
    'unknown' => 'Si è verificato un errore sconosciuto',
    'Reset password' => 'Reimposta la password',
    'Send password reset link' => 'Invia link per reimpostare la password',
    'Confirm Password' => 'Conferma Password',
    'Confirm' => 'Conferma',
    'Resend Verification Email' => 'Rinvia Email di Verifica',
    'Verify Your Email Address' => 'Verifica la tua email',
    'A fresh verification link has been sent to your email address.' => 'Un nuovo link di verifica è stato inviato al tuo indirizzo email.',
];
