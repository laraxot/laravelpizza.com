<?php

declare(strict_types=1);

return array (
  'passwords' => 
  array (
    'user' => 
    array (
      'label' => 'Non riusciamo a trovare un utente con questo indirizzo email.',
      'title' => 'Utente non trovato',
      'description' => 'Verifica che l\'indirizzo email sia corretto e riprova.',
    ),
    'token' => 
    array (
      'label' => 'Il token di reset password non è valido o è scaduto.',
      'title' => 'Token non valido',
      'description' => 'Il link di reset potrebbe essere scaduto. Richiedi un nuovo link.',
    ),
    'sent' => 
    array (
      'label' => 'Ti abbiamo inviato il link per reimpostare la password!',
      'title' => 'Link inviato',
      'description' => 'Controlla la tua casella di posta elettronica.',
    ),
    'reset' => 
    array (
      'label' => 'La tua password è stata reimpostata con successo!',
      'title' => 'Password reimpostata',
      'description' => 'Ora puoi accedere con la nuova password.',
    ),
    'throttled' => 
    array (
      'label' => 'Troppi tentativi di reset. Per favore attendi prima di riprovare.',
      'title' => 'Troppi tentativi',
      'description' => 'Attendi qualche minuto prima di richiedere un nuovo link.',
    ),
  ),
  'auth' => 
  array (
    'failed' => 
    array (
      'label' => 'Credenziali non valide.',
      'title' => 'Accesso negato',
      'description' => 'Email o password non corretti.',
    ),
    'throttle' => 
    array (
      'label' => 'Troppi tentativi di accesso. Riprova fra :seconds secondi.',
      'title' => 'Account temporaneamente bloccato',
      'description' => 'Per sicurezza, attendi prima di riprovare.',
    ),
    'unauthorized' => 
    array (
      'label' => 'Non hai i permessi necessari per questa operazione.',
      'title' => 'Accesso non autorizzato',
      'description' => 'Contatta l\'amministratore se pensi che questo sia un errore.',
    ),
  ),
  'validation' => 
  array (
    'required' => 
    array (
      'label' => 'Il campo :attribute è obbligatorio.',
      'title' => 'Campo obbligatorio',
      'description' => 'Compila tutti i campi richiesti per continuare.',
    ),
    'email' => 
    array (
      'label' => 'Il campo :attribute deve essere un indirizzo email valido.',
      'title' => 'Email non valida',
      'description' => 'Inserisci un indirizzo email nel formato corretto.',
    ),
    'min' => 
    array (
      'label' => 'Il campo :attribute deve avere almeno :min caratteri.',
      'title' => 'Lunghezza insufficiente',
      'description' => 'Il valore inserito è troppo corto.',
    ),
  ),
  'navigation' => 
  array (
    'name' => 'Errors',
    'plural' => 'Errors',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Errors',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'label' => 'Errors',
  'plural_label' => 'Errors (Plurale)',
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
      'label' => 'Crea Errors',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Errors',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Errors',
    ),
  ),
);
