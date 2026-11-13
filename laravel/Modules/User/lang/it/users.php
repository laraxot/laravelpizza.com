<?php

declare(strict_types=1);

// Etichette della tabella utenti (UsersTable / BaseUsersTable).
return [
    'fields' => [
        'name' => ['label' => 'Nome e cognome'],
        'email' => ['label' => 'Email'],
        'first_name' => ['label' => 'Nome'],
        'last_name' => ['label' => 'Cognome'],
        'is_active' => ['label' => 'Attivo'],
        'email_verified_at' => ['label' => 'Email verificata il'],
        'is_otp' => ['label' => 'Password temporanea'],
        'lang' => ['label' => 'Lingua'],
        'current_team_id' => ['label' => 'Team corrente'],
        'type' => ['label' => 'Tipo'],
        'state' => ['label' => 'Stato'],
        'password_expires_at' => ['label' => 'Scadenza password'],
        'id' => ['label' => 'ID'],
        'created_at' => ['label' => 'Creato il'],
        'updated_at' => ['label' => 'Aggiornato il'],
    ],
    'actions' => [
        'create' => ['label' => 'Nuovo utente'],
        'delete' => ['label' => 'Elimina'],
        'change_password' => ['label' => 'Cambia password', 'tooltip' => 'Imposta una nuova password'],
        'deactivate' => ['label' => 'Disattiva', 'tooltip' => 'Toglie l\'accesso: l\'utente viene eliminato (ripristinabile dal cestino)'],
        'edit' => ['label' => 'Modifica'],
        'view' => ['label' => 'Apri'],
        'verify_email' => ['label' => 'Segna email verificata'],
        'export' => ['label' => 'Esporta'],
    ],
];
