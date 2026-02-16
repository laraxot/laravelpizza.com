<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Permessi',
        'plural' => 'Permessi',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei permessi di sistema',
        ],
        'label' => 'Permessi',
        'sort' => '44',
        'icon' => 'user-permission-animated',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome Permesso',
            'tooltip' => 'Inserisci il nome del permesso, ad esempio \"Accesso Admin\".',
            'placeholder' => 'Nome del permesso',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Specifica la guardia associata al permesso.',
            'placeholder' => 'Nome della guardia, es. \"web\"',
        ],
        'roles' => [
            'label' => 'Ruoli',
            'tooltip' => 'Seleziona i ruoli a cui assegnare il permesso.',
            'placeholder' => 'Seleziona uno o più ruoli',
        ],
        'users' => [
            'label' => 'Utenti',
            'tooltip' => 'Seleziona gli utenti a cui assegnare il permesso.',
            'placeholder' => 'Seleziona uno o più utenti',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'La data in cui il permesso è stato creato.',
            'placeholder' => 'Data di creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => 'La data dell\'ultima modifica al permesso.',
            'placeholder' => 'Ultima modifica',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Fornisci una breve descrizione del permesso.',
            'placeholder' => 'Descrizione del permesso',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Permesso',
            'tooltip' => 'Clicca per creare un nuovo permesso nel sistema.',
            'icon' => 'fa fa-plus',
            'color' => 'success',
        ],
        'edit' => [
            'label' => 'Modifica Permesso',
            'tooltip' => 'Clicca per modificare un permesso esistente.',
            'icon' => 'fa fa-edit',
            'color' => 'primary',
        ],
        'delete' => [
            'label' => 'Elimina Permesso',
            'tooltip' => 'Clicca per eliminare un permesso esistente.',
            'icon' => 'fa fa-trash',
            'color' => 'danger',
        ],
        'assign_to_role' => [
            'label' => 'Assegna a Ruolo',
            'tooltip' => 'Clicca per assegnare questo permesso a un ruolo.',
            'icon' => 'fa fa-users',
            'color' => 'info',
        ],
        'remove_from_role' => [
            'label' => 'Rimuovi da Ruolo',
            'tooltip' => 'Clicca per rimuovere questo permesso da un ruolo.',
            'icon' => 'fa fa-user-times',
            'color' => 'warning',
        ],
        'assign_to_user' => [
            'label' => 'Assegna a Utente',
            'tooltip' => 'Clicca per assegnare questo permesso a un utente.',
            'icon' => 'fa fa-user-plus',
            'color' => 'info',
        ],
        'remove_from_user' => [
            'label' => 'Rimuovi da Utente',
            'tooltip' => 'Clicca per rimuovere questo permesso da un utente.',
            'icon' => 'fa fa-user-minus',
            'color' => 'warning',
        ],
    ],
    'messages' => [
        'created' => 'Permesso creato con successo',
        'updated' => 'Permesso aggiornato con successo',
        'deleted' => 'Permesso eliminato con successo',
        'assigned_to_role' => 'Permesso assegnato al ruolo con successo',
        'removed_from_role' => 'Permesso rimosso dal ruolo con successo',
        'assigned_to_user' => 'Permesso assegnato all\'utente con successo',
        'removed_from_user' => 'Permesso rimosso dall\'utente con successo',
        'in_use' => 'Non puoi eliminare un permesso in uso',
    ],
    'groups' => [
        'user_management' => [
            'name' => 'Gestione Utenti',
            'description' => 'Permessi relativi alla gestione degli utenti',
        ],
        'role_management' => [
            'name' => 'Gestione Ruoli',
            'description' => 'Permessi relativi alla gestione dei ruoli',
        ],
        'content_management' => [
            'name' => 'Gestione Contenuti',
            'description' => 'Permessi relativi alla gestione dei contenuti',
        ],
        'system_settings' => [
            'name' => 'Impostazioni Sistema',
            'description' => 'Permessi relativi alle impostazioni di sistema',
        ],
    ],
    'levels' => [
        'view' => 'Visualizza',
        'create' => 'Crea',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
        'manage' => 'Gestisci',
        'full' => 'Accesso Completo',
    ],
];
