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
        'sort' => '73',
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
        ],
    ],
    'actions' => [
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Profilo aggiornato con successo!',
            'error' => 'Errore durante l\'aggiornamento del profilo',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Profilo eliminato con successo!',
            'error' => 'Errore durante l\'eliminazione del profilo',
        ],
    ],
    'messages' => [
        'update_success' => 'Profilo aggiornato con successo!',
        'no_permission' => 'Non hai i permessi per modificare questo profilo.',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'privacy_policy' => [
        'title' => 'Datenschutzerklärung',
        'description' => 'Wie wir mit Ihren personenbezogenen Daten umgehen.',
    ],
    'delete_account' => [
        'title' => 'Konto löschen',
        'description' => 'Sobald Ihr Konto gelöscht ist, werden alle zugehörigen Ressourcen und Daten endgültig gelöscht. Laden Sie vor dem Fortfahren alle Daten herunter, die Sie behalten möchten.',
        'password_confirmation' => 'Bestätigen Sie Ihr Passwort',
        'delete' => 'Konto löschen',
        'button' => 'Konto löschen',
    ],
];
