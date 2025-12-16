<?php

declare(strict_types=1);

return [
    'actions' => [
        'attach_user' => 'Attach User',
        'associate_user' => 'Associate User',
        'user_actions' => 'User Actions',
        'view' => 'View',
        'edit' => 'Edit',
        'detach' => 'Detach',
        'row_actions' => 'Actions',
        'delete_selected' => 'Delete Selected',
        'confirm_detach' => 'Are you sure you want to detach this user?',
        'confirm_delete' => 'Are you sure you want to delete the selected users?',
        'success_attached' => 'User successfully attached',
        'success_detached' => 'User successfully detached',
        'success_deleted' => 'Users successfully deleted',
        'toggle_layout' => 'Toggle Layout',
        'create' => 'Create User',
        'delete' => 'Delete User',
        'associate' => 'Associate User',
        'bulk_delete' => 'Delete Selected',
        'bulk_detach' => 'Detach Selected',
        'impersonate' => 'Impersona Utente',
        'stop_impersonating' => 'Termina Impersonificazione',
        'block' => 'Blocca',
        'unblock' => 'Sblocca',
        'send_reset_link' => 'Invia Link Reset Password',
        'verify_email' => 'Verifica Email',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'description' => 'name',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'description' => 'email',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
        'role' => [
            'label' => 'Ruolo',
        ],
        'active' => 'Active',
        'id' => [
            'label' => 'ID',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'description' => 'password',
            'helper_text' => '',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la password',
        ],
        'email_verified_at' => [
            'label' => 'Email Verificata il',
        ],
        'current_password' => [
            'label' => 'Password Attuale',
            'placeholder' => 'Inserisci la password attuale',
        ],
        'roles' => [
            'label' => 'Ruoli',
        ],
        'permissions' => [
            'label' => 'Permessi',
        ],
        'status' => [
            'label' => 'Stato',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'blocked' => 'Bloccato',
            ],
        ],
        'last_login' => [
            'label' => 'Ultimo Accesso',
        ],
        'avatar' => [
            'label' => 'Avatar',
        ],
        'language' => [
            'label' => 'Lingua',
        ],
        'timezone' => [
            'label' => 'Fuso Orario',
        ],
        'password_expires_at' => [
            'label' => 'Scadenza Password',
        ],
        'verified' => [
            'label' => 'Verificato',
        ],
        'unverified' => [
            'label' => 'Non Verificato',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'isActive' => [
            'label' => 'isActive',
        ],
        'deactivate' => [
            'label' => 'deactivate',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'changePassword' => [
            'label' => 'changePassword',
        ],
    ],
    'filters' => [
        'active_users' => 'Active Users',
        'creation_date' => 'Creation Date',
        'date_from' => 'From',
        'date_to' => 'To',
        'verified' => 'Verified Users',
        'unverified' => 'Unverified Users',
    ],
    'messages' => [
        'no_records' => 'No users found',
        'loading' => 'Loading users...',
        'search' => 'Search users...',
        'credentials_incorrect' => 'The provided credentials are incorrect.',
        'created' => 'Utente creato con successo',
        'updated' => 'Utente aggiornato con successo',
        'deleted' => 'Utente eliminato con successo',
        'blocked' => 'Utente bloccato con successo',
        'unblocked' => 'Utente sbloccato con successo',
        'reset_link_sent' => 'Link per il reset della password inviato',
        'email_verified' => 'Email verificata con successo',
        'impersonating' => 'Stai impersonando l\'utente :name',
        // Added for LoginWidget
        'login_success' => 'Login successful',
        'validation_error' => 'Validation error',
        'login_error' => 'An error occurred during login. Please try again later.',
    ],
    'modals' => [
        'create' => [
            'heading' => 'Create User',
            'description' => 'Create a new user record',
            'actions' => [
                'submit' => 'Create',
                'cancel' => 'Cancel',
            ],
        ],
        'edit' => [
            'heading' => 'Edit User',
            'description' => 'Modify user information',
            'actions' => [
                'submit' => 'Save Changes',
                'cancel' => 'Cancel',
            ],
        ],
        'delete' => [
            'heading' => 'Delete User',
            'description' => 'Are you sure you want to delete this user?',
            'actions' => [
                'submit' => 'Delete',
                'cancel' => 'Cancel',
            ],
        ],
        'associate' => [
            'heading' => 'Associate User',
            'description' => 'Select a user to associate',
            'actions' => [
                'submit' => 'Associate',
                'cancel' => 'Cancel',
            ],
        ],
        'detach' => [
            'heading' => 'Detach User',
            'description' => 'Are you sure you want to detach this user?',
            'actions' => [
                'submit' => 'Detach',
                'cancel' => 'Cancel',
            ],
        ],
        'bulk_delete' => [
            'heading' => 'Delete Selected Users',
            'description' => 'Are you sure you want to delete the selected users?',
            'actions' => [
                'submit' => 'Delete Selected',
                'cancel' => 'Cancel',
            ],
        ],
        'bulk_detach' => [
            'heading' => 'Detach Selected Users',
            'description' => 'Are you sure you want to detach the selected users?',
            'actions' => [
                'submit' => 'Detach Selected',
                'cancel' => 'Cancel',
            ],
        ],
    ],
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
];
