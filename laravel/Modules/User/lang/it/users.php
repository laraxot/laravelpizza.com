<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome e cognome',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'first_name' => [
            'label' => 'Nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
        ],
        'is_active' => [
            'label' => 'Attivo',
        ],
        'email_verified_at' => [
            'label' => 'Email verificata il',
        ],
        'is_otp' => [
            'label' => 'Password temporanea',
        ],
        'lang' => [
            'label' => 'Lingua',
        ],
        'current_team_id' => [
            'label' => 'Team corrente',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'state' => [
            'label' => 'Stato',
        ],
        'password_expires_at' => [
            'label' => 'Scadenza password',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo utente',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'change_password' => [
            'label' => 'Cambia password',
            'tooltip' => 'Imposta una nuova password',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'tooltip' => 'Toglie l\'accesso: l\'utente viene eliminato (ripristinabile dal cestino)',
            'icon' => 'deactivate',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'edit',
            'icon' => 'edit',
        ],
        'view' => [
            'label' => 'Apri',
            'tooltip' => 'view',
            'icon' => 'view',
        ],
        'verify_email' => [
            'label' => 'Segna email verificata',
            'tooltip' => 'verify_email',
            'icon' => 'verify_email',
        ],
        'export' => [
            'label' => 'Esporta',
            'icon' => 'export',
            'tooltip' => 'export',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'changePassword' => [
            'label' => 'changePassword',
            'icon' => 'changePassword',
            'tooltip' => 'changePassword',
        ],
    ],
];
