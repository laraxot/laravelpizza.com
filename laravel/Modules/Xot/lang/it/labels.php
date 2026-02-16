<?php

declare(strict_types=1);

return array (
  'general' => 
  array (
    'all' => 'Tutti',
    'yes' => 'Sì',
    'no' => 'No',
    'custom' => 'Custom',
    'actions' => 'Azioni',
    'active' => 'Active',
    'buttons' => 
    array (
      'add' => 'Aggiungi',
      'save' => 'Salva',
      'update' => 'Aggiorna',
      'edit' => 'Cambia',
    ),
    'hide' => 'Nascondi',
    'inactive' => 'Inactive',
    'none' => 'Nessuno',
    'show' => 'Visualizza',
    'toggle_navigation' => 'Menu Navigazione',
  ),
  'backend' => 
  array (
    'access' => 
    array (
      'roles' => 
      array (
        'create' => 'Crea ruolo',
        'edit' => 'Modifica ruolo',
        'management' => 'Gestione ruolo',
        'table' => 
        array (
          'number_of_users' => 'Numero di utenti',
          'permissions' => 'Permessi',
          'role' => 'Ruolo',
          'sort' => 'Ordina',
          'total' => 'Ruolo|Totale ruoli',
        ),
      ),
      'users' => 
      array (
        'active' => 'Utenti attivi',
        'all_permissions' => 'Tutti i permessi',
        'change_password' => 'Cambia password',
        'change_password_for' => 'Cambia password per :user',
        'create' => 'Crea utente',
        'deactivated' => 'Utenti disattivati',
        'deleted' => 'Utenti eliminati',
        'edit' => 'Modifica utente',
        'management' => 'Gestione utente',
        'no_permissions' => 'Nessun permesso',
        'no_roles' => 'Nessuno ruolo da assegnare.',
        'permissions' => 'Permessi',
        'table' => 
        array (
          'confirmed' => 'Confermato',
          'created' => 'Creato',
          'email' => 'E-mail',
          'id' => 'ID',
          'last_updated' => 'Ultimo aggiornamento',
          'name' => 'Nome',
          'no_deactivated' => 'Nessun utente disattivato',
          'no_deleted' => 'Nessun utente eliminato',
          'roles' => 'Ruoli',
          'total' => 'utente(i] totali',
        ),
        'tabs' => 
        array (
          'titles' => 
          array (
            'overview' => 'Overview',
            'history' => 'History',
          ),
          'content' => 
          array (
            'overview' => 
            array (
              'avatar' => 'Avatar',
              'confirmed' => 'Confirmed',
              'created_at' => 'Created At',
              'deleted_at' => 'Deleted At',
              'email' => 'E-mail',
              'last_updated' => 'Last Updated',
              'name' => 'Name',
              'status' => 'Status',
            ),
          ),
        ),
        'view' => 'View User',
      ),
    ),
  ),
  'frontend' => 
  array (
    'auth' => 
    array (
      'login_box_title' => 'Login',
      'login_button' => 'Login',
      'login_with' => 'Login tramite :social_media',
      'register_box_title' => 'Registrazione',
      'register_button' => 'Registrati',
      'remember_me' => 'Ricordami',
    ),
    'passwords' => 
    array (
      'forgot_password' => 'Password dimenticata?',
      'reset_password_box_title' => 'Reset password',
      'reset_password_button' => 'Reset password',
      'send_password_reset_link_button' => 'Invia link per il reset della password',
    ),
    'macros' => 
    array (
      'country' => 
      array (
        'alpha' => 'Codici di Paese alfabetici',
        'alpha2' => 'Codici di Paese alfabetici 2',
        'alpha3' => 'Codici di Paese alfabetici 3',
        'numeric' => 'Codici di Paese numerici',
      ),
      'macro_examples' => 'Esempi di macro',
      'state' => 
      array (
        'mexico' => 'Elenco di stati del Messico',
        'us' => 
        array (
          'us' => 'Stati degli USA',
          'outlying' => 'Territori remoti degli USA',
          'armed' => 'Forze armate USA',
        ),
      ),
      'territories' => 
      array (
        'canada' => 'Province e Territori del Canada',
      ),
      'timezone' => 'Fuso orario',
    ),
    'user' => 
    array (
      'passwords' => 
      array (
        'change' => 'Change Password',
      ),
      'profile' => 
      array (
        'avatar' => 'Avatar',
        'created_at' => 'Data di creazione',
        'edit_information' => 'Modifica informazioni',
        'email' => 'E-mail',
        'last_updated' => 'Ultimo aggiornamento',
        'name' => 'Nome',
        'update_information' => 'Aggiorna informazioni',
      ),
    ),
  ),
  'label' => 'Labels',
  'plural_label' => 'Labels (Plurale)',
  'navigation' => 
  array (
    'name' => 'Labels',
    'plural' => 'Labels',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Labels',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
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
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Labels',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Labels',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Labels',
    ),
  ),
);
