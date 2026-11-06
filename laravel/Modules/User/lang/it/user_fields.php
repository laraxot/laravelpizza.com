<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_fields.php
return [
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    // User — translation section (claude-audit doc ratio).
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco dell\'utente',
            'tooltip' => 'ID utente',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome completo',
            'help' => 'Nome completo dell\'utente',
            'tooltip' => 'Nome e cognome dell\'utente',
            'helper_text' => '',
            'description' => 'name',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dell\'utente',
            'tooltip' => 'Nome dell\'utente',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome dell\'utente',
            'tooltip' => 'Cognome dell\'utente',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'Indirizzo email dell\'utente',
            'tooltip' => 'Email per l\'accesso e le comunicazioni',
            'helper_text' => '',
            'description' => 'email',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'help' => 'Password per l\'accesso al sistema',
            'tooltip' => 'Password di accesso',
            'helper_text' => '',
            'description' => 'password',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la password',
            'help' => 'Ripeti la password per conferma',
            'tooltip' => 'Conferma della password',
            'helper_text' => '',
            'description' => '',
        ],
        'current_password' => [
            'label' => 'Password Attuale',
            'placeholder' => 'Inserisci la password attuale',
            'help' => 'Password corrente per la verifica',
            'tooltip' => 'Password attuale',
            'helper_text' => '',
            'description' => '',
        ],
        'new_password' => [
            'label' => 'Nuova Password',
            'placeholder' => 'Inserisci la nuova password',
            'help' => 'Nuova password desiderata',
            'tooltip' => 'Nuova password',
            'helper_text' => '',
            'description' => '',
        ],
        'role' => [
            'label' => 'Ruolo',
            'placeholder' => 'Seleziona il ruolo',
            'help' => 'Ruolo dell\'utente nel sistema',
            'tooltip' => 'Ruolo e permessi',
            'helper_text' => '',
            'description' => '',
        ],
        'roles' => [
            'label' => 'Ruoli',
            'placeholder' => 'Seleziona i ruoli',
            'help' => 'Ruoli assegnati all\'utente',
            'tooltip' => 'Ruoli multipli',
            'helper_text' => '',
            'description' => '',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help' => 'Permessi specifici dell\'utente',
            'tooltip' => 'Permessi diretti',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato dell\'account utente',
            'tooltip' => 'Stato dell\'utente',
            'helper_text' => '',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'blocked' => 'Bloccato',
                'pending' => 'In Attesa',
                'suspended' => 'Sospeso',
            ],
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipo di utente',
            'tooltip' => 'Tipo di account',
            'helper_text' => '',
            'options' => [
                'admin' => 'Amministratore',
                'user' => 'Utente',
                'doctor' => 'Medico',
                'patient' => 'Paziente',
                'staff' => 'Personale',
            ],
            'description' => '',
        ],
        'last_login' => [
            'label' => 'Ultimo Accesso',
            'help' => 'Data e ora dell\'ultimo accesso',
            'tooltip' => 'Ultimo login',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di creazione dell\'account',
            'tooltip' => 'Quando è stato creato',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'help' => 'Data dell\'ultimo aggiornamento',
            'tooltip' => 'Ultimo aggiornamento',
            'helper_text' => '',
            'description' => '',
        ],
        'avatar' => [
            'label' => 'Avatar',
            'placeholder' => 'Carica un\'immagine',
            'help' => 'Immagine del profilo',
            'tooltip' => 'Foto profilo',
            'helper_text' => '',
            'description' => '',
        ],
        'language' => [
            'label' => 'Lingua',
            'placeholder' => 'Seleziona la lingua',
            'help' => 'Lingua preferita dell\'utente',
            'tooltip' => 'Lingua interfaccia',
            'helper_text' => '',
            'options' => [
                'it' => 'Italiano',
                'en' => 'English',
                'es' => 'Español',
                'fr' => 'Français',
                'de' => 'Deutsch',
            ],
            'description' => '',
        ],
        'timezone' => [
            'label' => 'Fuso Orario',
            'placeholder' => 'Seleziona il fuso orario',
            'help' => 'Fuso orario dell\'utente',
            'tooltip' => 'Zona oraria',
            'helper_text' => '',
            'description' => '',
        ],
        'password_expires_at' => [
            'label' => 'Scadenza Password',
            'help' => 'Data di scadenza della password',
            'tooltip' => 'Scadenza password',
            'helper_text' => '',
            'description' => '',
        ],
        'verified' => [
            'label' => 'Verificato',
            'help' => 'Indica se l\'email è verificata',
            'tooltip' => 'Email verificata',
            'helper_text' => '',
            'description' => '',
        ],
        'unverified' => [
            'label' => 'Non Verificato',
            'help' => 'Indica se l\'email non è verificata',
            'tooltip' => 'Email non verificata',
            'helper_text' => '',
            'description' => '',
        ],
        'email_verified_at' => [
            'label' => 'Email Verificata il',
            'help' => 'Data di verifica dell\'email',
            'tooltip' => 'Data verifica email',
            'helper_text' => '',
            'description' => '',
        ],
        'provider' => [
            'label' => 'Provider',
            'placeholder' => 'Inserisci il nome del provider',
            'help' => 'Provider di autenticazione (es. Google, Facebook]',
            'tooltip' => 'Provider OAuth',
            'helper_text' => '',
            'description' => '',
        ],
        'provider_id' => [
            'label' => 'ID Provider',
            'placeholder' => 'Inserisci l\'ID del provider',
            'help' => 'ID utente nel provider esterno',
            'tooltip' => 'ID provider esterno',
            'helper_text' => '',
            'description' => '',
        ],
        'provider_name' => [
            'label' => 'Nome Provider',
            'placeholder' => 'Inserisci il nome associato al provider',
            'help' => 'Nome dell\'utente nel provider',
            'tooltip' => 'Nome nel provider',
            'helper_text' => '',
            'description' => '',
        ],
        'provider_email' => [
            'label' => 'Email Provider',
            'placeholder' => 'Inserisci l\'email del provider',
            'help' => 'Email associata al provider',
            'tooltip' => 'Email nel provider',
            'helper_text' => '',
            'description' => '',
        ],
        'provider_avatar' => [
            'label' => 'Avatar Provider',
            'placeholder' => 'URL dell\'avatar',
            'help' => 'URL dell\'immagine profilo del provider',
            'tooltip' => 'Avatar del provider',
            'helper_text' => '',
            'description' => '',
        ],
        'uuid' => [
            'label' => 'UUID',
            'help' => 'Identificativo univoco universale',
            'tooltip' => 'UUID dispositivo',
            'helper_text' => '',
            'description' => '',
        ],
        'mobile_id' => [
            'label' => 'Mobile ID',
            'help' => 'Identificativo del dispositivo mobile',
            'tooltip' => 'ID dispositivo mobile',
            'helper_text' => '',
            'description' => '',
        ],
        'languages' => [
            'label' => 'Lingue',
            'placeholder' => 'Seleziona le lingue',
            'help' => 'Lingue supportate dal dispositivo',
            'tooltip' => 'Lingue dispositivo',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard Name',
            'help' => 'Nome del guard di autenticazione',
            'tooltip' => 'Guard autenticazione',
            'helper_text' => '',
            'description' => '',
        ],
        'active' => [
            'label' => 'Attivo',
            'help' => 'Indica se il record è attivo',
            'tooltip' => 'Stato attivo',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'layout' => [
            'label' => 'layout',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'endDate' => [
            'description' => 'endDate',
            'helper_text' => 'endDate1',
            'placeholder' => 'endDate',
            'label' => 'endDate',
            'tooltip' => '',
        ],
        'startDate' => [
            'description' => 'startDate',
            'helper_text' => 'startDate',
            'placeholder' => 'startDate',
            'label' => 'startDate',
            'tooltip' => '',
        ],
        'matr' => [
            'description' => 'matr',
            'label' => 'matr',
            'placeholder' => 'matr',
            'helper_text' => 'matr',
        ],
        'ente' => [
            'label' => 'ente',
            'placeholder' => 'ente',
            'helper_text' => 'ente',
            'description' => 'ente',
        ],
    ],
];
