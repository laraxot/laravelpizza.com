<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Password',
    'plural' => 'Passwords',
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
    'otp_expiration_minutes' => 
    array (
      'help' => 'Durata in minuti della validità della password temporanea',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'otp_length' => 
    array (
      'help' => 'Lunghezza del codice OTP',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires_in' => 
    array (
      'help' => 'Il numero di giorni prima che la password scadrà',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'min' => 
    array (
      'help' => 'La dimensione minima della password',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'mixedCase' => 
    array (
      'help' => 'la password richiede almeno una lettera maiuscola e una minuscola',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'letters' => 
    array (
      'help' => 'la password richiede almeno una lettera',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'numbers' => 
    array (
      'help' => 'la password richiede almeno un numero',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'symbols' => 
    array (
      'help' => 'la password richiede almeno un simbolo',
      'label' => 
      array (
        'help' => 'la password richiede almeno un simbolo',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'uncompromised' => 
    array (
      'help' => 'Se la password non deve essere stata compromessa in data leaks',
      'label' => 
      array (
        'help' => 'Se la password non deve essere stata compromessa in data leaks',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'compromisedThreshold' => 
    array (
      'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
      'label' => 
      array (
        'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'new_password',
      'fields' => 
      array (
        'label' => 'new_password',
      ),
      'description' => 'new_password',
      'helper_text' => 'new_password',
      'placeholder' => 'new_password',
      'tooltip' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la password',
      'helper_text' => 'La password deve essere di almeno 8 caratteri',
      'description' => 'Password',
      'tooltip' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Conferma la password',
      'helper_text' => 'Reinserisci la password per confermare',
      'description' => 'Conferma Password',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
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
        'name' => 'Nome area',
        'parent_name' => 'Nome area livello superiore',
      ),
    ),
    'change_password' => 'Cambio password',
    'updateDataAction' => 
    array (
      'label' => 'updateDataAction',
    ),
  ),
  'label' => 'Password',
  'plural_label' => 'Password (Plurale)',
);
