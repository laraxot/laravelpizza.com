<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Utente',
    'plural' => 'Utenti',
    'group' => 
    array (
      'name' => 'Admin',
    ),
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data di Creazione',
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
    'role' => 
    array (
      'name' => 
      array (
        'label' => 'Ruolo',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'active' => 
    array (
      'label' => 'Attivo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email_verified_at' => 
    array (
      'label' => 'Email Verificata',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'teams' => 
    array (
      'name' => 
      array (
        'label' => 'Nome Team',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'roles' => 
    array (
      'name' => 
      array (
        'label' => 'Nome Ruolo',
      ),
      'label' => '',
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
    'deactivate' => 
    array (
      'label' => 'deactivate',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'changePassword' => 
    array (
      'label' => 'changePassword',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'active_users' => 'Utenti Attivi',
    'creation_date' => 'Data di Creazione',
    'date_from' => 'Dal',
    'date_to' => 'Al',
    'verified' => 'Utenti Verificati',
    'unverified' => 'Utenti Non Verificati',
  ),
  'messages' => 
  array (
    'no_records' => 'Nessun utente trovato',
    'loading' => 'Caricamento utenti...',
    'search' => 'Cerca utenti...',
  ),
  'actions' => 
  array (
    'toggle_layout' => 'Cambia Layout',
    'create' => 
    array (
      'label' => 'Crea Utente',
    ),
    'delete' => 'Elimina Utente',
    'associate' => 'Associa Utente',
    'bulk_delete' => 'Elimina Selezionati',
    'bulk_detach' => 'Scollega Selezionati',
    'attach_user' => 'Collega Utente',
    'associate_user' => 'Associa Utente',
    'user_actions' => 'Azioni Utente',
    'view' => 'Visualizza',
    'edit' => 'Modifica',
    'detach' => 'Scollega',
    'row_actions' => 'Azioni',
    'delete_selected' => 'Elimina Selezionati',
    'confirm_detach' => 'Sei sicuro di voler scollegare questo utente?',
    'confirm_delete' => 'Sei sicuro di voler eliminare gli utenti selezionati?',
    'success_attached' => 'Utente collegato con successo',
    'success_detached' => 'Utente scollegato con successo',
    'success_deleted' => 'Utenti eliminati con successo',
    'import' => 
    array (
      'fields' => 
      array (
        'import_file' => 'Seleziona un file XLS o CSV da caricare',
      ),
    ),
    'export' => 
    array (
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 'Nome Area',
        'parent_name' => 'Nome Area Superiore',
      ),
    ),
    'change_password' => 'Cambia Password',
  ),
  'modals' => 
  array (
    'create' => 
    array (
      'heading' => 'Crea Utente',
      'description' => 'Crea un nuovo utente',
      'actions' => 
      array (
        'submit' => 'Crea',
        'cancel' => 'Annulla',
      ),
    ),
    'edit' => 
    array (
      'heading' => 'Modifica Utente',
      'description' => 'Modifica le informazioni dell’utente',
      'actions' => 
      array (
        'submit' => 'Salva Modifiche',
        'cancel' => 'Annulla',
      ),
    ),
    'delete' => 
    array (
      'heading' => 'Elimina Utente',
      'description' => 'Sei sicuro di voler eliminare questo utente?',
      'actions' => 
      array (
        'submit' => 'Elimina',
        'cancel' => 'Annulla',
      ),
    ),
    'associate' => 
    array (
      'heading' => 'Associa Utente',
      'description' => 'Seleziona un utente da associare',
      'actions' => 
      array (
        'submit' => 'Associa',
        'cancel' => 'Annulla',
      ),
    ),
    'detach' => 
    array (
      'heading' => 'Scollega Utente',
      'description' => 'Sei sicuro di voler scollegare questo utente?',
      'actions' => 
      array (
        'submit' => 'Scollega',
        'cancel' => 'Annulla',
      ),
    ),
    'bulk_delete' => 
    array (
      'heading' => 'Elimina Utenti Selezionati',
      'description' => 'Sei sicuro di voler eliminare gli utenti selezionati?',
      'actions' => 
      array (
        'submit' => 'Elimina Selezionati',
        'cancel' => 'Annulla',
      ),
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
