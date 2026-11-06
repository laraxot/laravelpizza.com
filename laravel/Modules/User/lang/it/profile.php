<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Profilo',
        'plural' => 'Profili',
        'group' => [
            'label' => 'Gestione Utenti',
            'description' => 'Gestione dei profili utente',
        ],
        'icon' => 'user-profile-animated',
        'sort' => 73,
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dell\'utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome dell\'utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'Indirizzo email dell\'utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono dell\'utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'Seleziona la data di nascita',
            'help' => 'Data di nascita dell\'utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'gender' => [
            'label' => 'Genere',
            'male' => 'Maschio',
            'female' => 'Femmina',
            'other' => 'Altro',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Stato attivo del profilo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'ente' => [
            'label' => 'Ente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'placeholder' => 'ente',
        ],
        'matr' => [
            'label' => 'Matricola',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'placeholder' => 'matr',
        ],
        'photo' => [
            'label' => 'photo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user' => [
            'name' => [
                'label' => 'user.name',
            ],
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'name' => [
            'label' => 'name',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
        'password' => [
            'label' => 'password',
            'placeholder' => 'password',
            'helper_text' => 'password',
            'description' => 'password',
        ],
        'passwordConfirmation' => [
            'label' => 'passwordConfirmation',
            'placeholder' => 'passwordConfirmation',
            'helper_text' => 'passwordConfirmation',
            'description' => 'passwordConfirmation',
        ],
        'currentPassword' => [
            'label' => 'currentPassword',
            'placeholder' => 'currentPassword',
            'helper_text' => 'currentPassword',
            'description' => 'currentPassword',
        ],
        'email_verified_at' => [
            'label' => 'email_verified_at',
            'placeholder' => 'email_verified_at',
            'helper_text' => 'email_verified_at',
            'description' => 'email_verified_at',
        ],
        'password_confirmation' => [
            'label' => 'password_confirmation',
            'placeholder' => 'password_confirmation',
            'helper_text' => 'password_confirmation',
            'description' => 'password_confirmation',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
    ],
    'actions' => [
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Profilo aggiornato con successo!',
            'error' => 'Errore durante l\'aggiornamento del profilo',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Profilo eliminato con successo!',
            'error' => 'Errore durante l\'eliminazione del profilo',
            'tooltip' => 'delete',
            'icon' => 'delete',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'create' => [
            'tooltip' => 'create',
            'icon' => 'create',
            'label' => 'create',
        ],
        'showPassword' => [
            'label' => 'showPassword',
            'icon' => 'showPassword',
            'tooltip' => 'showPassword',
        ],
        'hidePassword' => [
            'label' => 'hidePassword',
            'icon' => 'hidePassword',
            'tooltip' => 'hidePassword',
        ],
        'attach' => [
            'label' => 'attach',
            'icon' => 'attach',
            'tooltip' => 'attach',
        ],
        'detach' => [
            'label' => 'detach',
            'icon' => 'detach',
            'tooltip' => 'detach',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'back' => [
            'label' => 'back',
            'icon' => 'back',
            'tooltip' => 'back',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => 'submit',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
    ],
    'messages' => [
        'update_success' => 'Profilo aggiornato con successo!',
        'no_permission' => 'Non hai i permessi per modificare questo profilo.',
    ],
    'privacy_policy' => [
        'title' => 'Informativa sulla privacy',
        'description' => 'Come trattiamo i tuoi dati personali.',
    ],
    'label' => 'Profile',
    'plural_label' => 'Profile (Plurale)',
    'delete_account' => [
        'title' => 'Elimina account',
        'description' => 'Una volta eliminato l\'account, tutte le sue risorse e i suoi dati verranno eliminati definitivamente. Prima di procedere, scarica i dati che desideri conservare.',
        'password_confirmation' => 'Conferma la tua password',
        'button' => 'Elimina account',
        'delete' => 'Elimina account',
    ],
];
