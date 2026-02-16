<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'users' => [
                'activate' => 'Attiva',
                'change_password' => 'Cambia password',
                'deactivate' => 'Disattiva',
                'delete_permanently' => 'Elimina definitivamente',
                'login_as' => 'Login As :user',
                'resend_email' => 'Reinvia e-mail di conferma',
                'restore_user' => 'Ripristina utente',
            ],
        ],
    ],
    'emails' => [
        'auth' => [
            'confirm_account' => 'Confirm Account',
            'reset_password' => 'Reset Password',
        ],
    ],
    'general' => [
        'cancel' => 'Annulla',
        'crud' => [
            'create' => 'Crea',
            'delete' => 'Elimina',
            'edit' => 'Modifica',
            'update' => 'Aggiorna',
            'view' => 'View',
        ],
        'save' => 'Salva',
        'view' => 'Visualizza',
    ],
    'save' => 'Salva',
    'close' => 'Chiudi',
    'back' => 'Indietro',
    'confirm' => 'Conferma',
    'label' => 'Buttons',
    'plural_label' => 'Buttons (Plurale)',
    'navigation' => [
        'name' => 'Buttons',
        'plural' => 'Buttons',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Buttons',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Buttons',
        ],
        'edit' => [
            'label' => 'Modifica Buttons',
        ],
        'delete' => [
            'label' => 'Elimina Buttons',
        ],
    ],
];
