<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Utenti',
    'plural' => 'Utenti',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione degli utenti e dei loro permessi',
    ),
    'label' => 'Utenti',
    'sort' => '26',
    'icon' => 'user-main',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'description' => 'name',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
      'description' => 'email',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la password',
      'description' => 'password',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Conferma la password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'current_password' => 
    array (
      'label' => 'Password Attuale',
      'placeholder' => 'Inserisci la password attuale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'role' => 
    array (
      'label' => 'Ruolo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'roles' => 
    array (
      'label' => 'Ruoli',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'options' => 
      array (
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'blocked' => 'Bloccato',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_login' => 
    array (
      'label' => 'Ultimo Accesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'avatar' => 
    array (
      'label' => 'Avatar',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'language' => 
    array (
      'label' => 'Lingua',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timezone' => 
    array (
      'label' => 'Fuso Orario',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_expires_at' => 
    array (
      'label' => 'Scadenza Password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'verified' => 
    array (
      'label' => 'Verificato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'unverified' => 
    array (
      'label' => 'Non Verificato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'isActive' => 
    array (
      'label' => 'isActive',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'deactivate' => 
    array (
      'label' => 'deactivate',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'delete' => 
    array (
      'label' => 'delete',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'edit' => 
    array (
      'label' => 'edit',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'view' => 
    array (
      'label' => 'view',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'create' => 
    array (
      'label' => 'create',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email_verified_at' => 
    array (
      'label' => 'Email Verificata il',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'detach' => 
    array (
      'label' => 'detach',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'attach' => 
    array (
      'label' => 'attach',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Crea Utente',
    'edit' => 'Modifica Utente',
    'delete' => 'Elimina Utente',
    'impersonate' => 'Impersona Utente',
    'stop_impersonating' => 'Termina Impersonificazione',
    'block' => 'Blocca',
    'unblock' => 'Sblocca',
    'send_reset_link' => 'Invia Link Reset Password',
    'verify_email' => 'Verifica Email',
  ),
  'messages' => 
  array (
    'created' => 'Utente creato con successo',
    'updated' => 'Utente aggiornato con successo',
    'deleted' => 'Utente eliminato con successo',
    'blocked' => 'Utente bloccato con successo',
    'unblocked' => 'Utente sbloccato con successo',
    'reset_link_sent' => 'Link per il reset della password inviato',
    'email_verified' => 'Email verificata con successo',
    'impersonating' => 'Stai impersonando l\'utente :name',
    'credentials_incorrect' => 'Die angegebenen Anmeldedaten sind nicht korrekt',
    'login_success' => 'Anmeldung erfolgreich',
    'validation_error' => 'Validierungsfehler',
    'login_error' => 'Bei der Anmeldung ist ein Fehler aufgetreten. Versuchen Sie es später erneut',
  ),
  'validation' => 
  array (
    'email_unique' => 'Questa email è già in uso',
    'password_min' => 'La password deve essere di almeno :min caratteri',
    'password_confirmed' => 'Le password non coincidono',
    'current_password' => 'La password attuale non è corretta',
  ),
  'permissions' => 
  array (
    'view_users' => 'Visualizza utenti',
    'create_users' => 'Crea utenti',
    'edit_users' => 'Modifica utenti',
    'delete_users' => 'Elimina utenti',
    'impersonate_users' => 'Impersona utenti',
    'manage_roles' => 'Gestisci ruoli',
  ),
  'model' => 
  array (
    'label' => 'Utente',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
