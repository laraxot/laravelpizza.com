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
        ],
        'matr' => [
            'label' => 'Matricola',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'photo' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user' => [
            'name' => [
                'label' => 'user.name',
            ],
        ],
    ],
    'actions' => [
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Profilo aggiornato con successo!',
            'error' => 'Errore durante l\'aggiornamento del profilo',
            'icon' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Profilo eliminato con successo!',
            'error' => 'Errore durante l\'eliminazione del profilo',
            'icon' => 'delete',
        ],
        'layout' => [
            'icon' => 'layout',
        ],
        'create' => [
            'icon' => 'create',
        ],
        'showPassword' => [
            'icon' => 'showPassword',
        ],
        'hidePassword' => [
            'icon' => 'hidePassword',
        ],
        'attach' => [
            'icon' => 'attach',
        ],
        'detach' => [
            'icon' => 'detach',
        ],
        'view' => [
            'icon' => 'view',
        ],
        'save' => [
            'icon' => 'save',
        ],
        'back' => [
            'icon' => 'back',
        ],
        'createAnother' => [
            'icon' => 'createAnother',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'icon' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
        ],
        'submit' => [
            'icon' => 'submit',
        ],
        'cancel' => [
            'icon' => 'cancel',
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
