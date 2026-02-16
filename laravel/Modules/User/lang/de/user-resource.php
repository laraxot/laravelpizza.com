<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Il nome dell\'utente',
      'validation' => 
      array (
        'required' => 'Der Name ist erforderlich',
        'max' => 'Il nome non può superare i 255 caratteri',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Il cognome dell\'utente',
      'validation' => 
      array (
        'required' => 'Il cognome è obbligatorio',
        'max' => 'Il cognome non può superare i 255 caratteri',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
      'help' => 'L\'email dell\'utente',
      'validation' => 
      array (
        'required' => 'L\'email è obbligatoria',
        'email' => 'Inserisci un\'email valida',
        'max' => 'L\'email non può superare i 255 caratteri',
        'unique' => 'Questa email è già registrata',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la password',
      'help' => 'La password deve essere di almeno 8 caratteri',
      'validation' => 
      array (
        'required' => 'La password è obbligatoria',
        'min' => 'La password deve essere di almeno 8 caratteri',
        'max' => 'La password non può superare i 255 caratteri',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Conferma la password',
      'help' => 'Reinserisci la password per confermare',
      'validation' => 
      array (
        'required' => 'La conferma della password è obbligatoria',
        'min' => 'La password deve essere di almeno 8 caratteri',
        'max' => 'La password non può superare i 255 caratteri',
        'same' => 'Le password non coincidono',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'remember_me' => 
    array (
      'label' => 'Ricordami',
      'help' => 'Mantieni la sessione attiva',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Utente',
      'tooltip' => 'Crea un nuovo utente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica l\'utente',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina l\'utente',
    ),
  ),
  'teams' => 
  array (
    'personal_team' => 
    array (
      'label' => 'Team Personale',
      'help' => 'Il team personale dell\'utente',
    ),
  ),
  'devices' => 
  array (
    'fields' => 
    array (
      'uuid' => 
      array (
        'label' => 'UUID',
        'help' => 'Identificativo univoco del dispositivo',
      ),
      'mobile_id' => 
      array (
        'label' => 'Mobile ID',
        'help' => 'Identificativo del dispositivo mobile',
      ),
      'languages' => 
      array (
        'label' => 'Lingue',
        'help' => 'Le lingue supportate dal dispositivo',
      ),
      'device_name' => 
      array (
        'label' => 'Nome Dispositivo',
        'help' => 'Il nome del dispositivo',
      ),
    ),
  ),
  'permissions' => 
  array (
    'fields' => 
    array (
      'name' => 
      array (
        'label' => 'Nome',
        'help' => 'Il nome del permesso',
      ),
      'guard_name' => 
      array (
        'label' => 'Guard Name',
        'help' => 'Il nome della guardia',
      ),
      'active' => 
      array (
        'label' => 'Attivo',
        'help' => 'Stato di attivazione del permesso',
      ),
      'created_at' => 
      array (
        'label' => 'Data Creazione',
        'help' => 'Data di creazione del permesso',
      ),
    ),
  ),
  'widgets' => 
  array (
    'recent_logins' => 
    array (
      'fields' => 
      array (
        'user' => 
        array (
          'label' => 'Utente',
          'help' => 'L\'utente che ha effettuato l\'accesso',
        ),
        'login_at' => 
        array (
          'label' => 'Data Accesso',
          'help' => 'Data e ora dell\'accesso',
        ),
        'ip_address' => 
        array (
          'label' => 'Indirizzo IP',
          'help' => 'L\'indirizzo IP dell\'utente',
        ),
        'user_agent' => 
        array (
          'label' => 'User Agent',
          'help' => 'Il browser dell\'utente',
        ),
      ),
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
