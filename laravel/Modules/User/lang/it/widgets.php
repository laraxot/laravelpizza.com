<?php

declare(strict_types=1);

return array (
  'edit_user' => 
  array (
    'title' => 'Modifica Profilo Utente',
    'description' => 'Aggiorna le informazioni del profilo utente',
    'sections' => 
    array (
      'personal_info' => 
      array (
        'title' => 'Informazioni Personali',
        'description' => 'Dati anagrafici e contatti',
      ),
      'preferences' => 
      array (
        'title' => 'Preferenze',
        'description' => 'Impostazioni personali e lingua',
      ),
      'security' => 
      array (
        'title' => 'Sicurezza',
        'description' => 'Password e impostazioni di sicurezza',
      ),
      'admin_settings' => 
      array (
        'title' => 'Impostazioni Amministratore',
        'description' => 'Configurazioni riservate agli amministratori',
      ),
    ),
    'fields' => 
    array (
      'profile_photo_path' => 
      array (
        'label' => 'Foto Profilo',
        'placeholder' => 'Carica una foto profilo',
        'help' => 'Formati supportati: JPEG, PNG, WebP. Dimensione massima: 2MB',
      ),
      'first_name' => 
      array (
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Il tuo nome di battesimo',
      ),
      'last_name' => 
      array (
        'label' => 'Cognome',
        'placeholder' => 'Inserisci il cognome',
        'help' => 'Il tuo cognome',
      ),
      'name' => 
      array (
        'label' => 'Nome Completo',
        'placeholder' => 'Inserisci il nome completo',
        'help' => 'Nome e cognome come devono apparire nel sistema',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Inserisci l\'indirizzo email',
        'help' => 'Indirizzo email per accesso e comunicazioni',
      ),
      'lang' => 
      array (
        'label' => 'Lingua',
        'placeholder' => 'Seleziona la lingua',
        'help' => 'Lingua dell\'interfaccia utente',
        'options' => 
        array (
          'it' => 'Italiano',
          'en' => 'English',
          'es' => 'Español',
          'fr' => 'Français',
          'de' => 'Deutsch',
        ),
      ),
      'password' => 
      array (
        'label' => 'Nuova Password',
        'placeholder' => 'Inserisci una nuova password',
        'help' => 'Lascia vuoto per mantenere la password attuale',
      ),
      'password_confirmation' => 
      array (
        'label' => 'Conferma Password',
        'placeholder' => 'Conferma la nuova password',
        'help' => 'Ripeti la nuova password per conferma',
      ),
      'is_otp' => 
      array (
        'label' => 'Autenticazione a Due Fattori (OTP]',
        'help' => 'Abilita l\'autenticazione a due fattori per maggiore sicurezza',
      ),
      'password_expires_at' => 
      array (
        'label' => 'Scadenza Password',
        'placeholder' => 'Seleziona data e ora di scadenza',
        'help' => 'Data e ora in cui la password scadrà',
      ),
      'is_active' => 
      array (
        'label' => 'Account Attivo',
        'help' => 'Determina se l\'account è attivo e può accedere al sistema',
      ),
    ),
    'actions' => 
    array (
      'save' => 
      array (
        'label' => 'Salva Modifiche',
        'tooltip' => 'Salva le modifiche apportate al profilo',
      ),
      'cancel' => 
      array (
        'label' => 'Annulla',
        'tooltip' => 'Annulla le modifiche e ripristina i valori originali',
      ),
    ),
    'messages' => 
    array (
      'saved' => 'Profilo aggiornato con successo',
      'cancelled' => 'Modifiche annullate',
      'error' => 'Si è verificato un errore durante il salvataggio',
      'unauthorized' => 'Non sei autorizzato a modificare questo profilo',
    ),
    'validation' => 
    array (
      'email_unique' => 'Questo indirizzo email è già in uso',
      'password_confirmation' => 'La conferma password non corrisponde',
      'required' => 'Questo campo è obbligatorio',
    ),
  ),
  'registration' => 
  array (
    'title' => 'Registrazione Utente',
    'description' => 'Crea un nuovo account utente',
    'fields' => 
    array (
      'type' => 
      array (
        'label' => 'Tipo Utente',
        'placeholder' => 'Seleziona il tipo di utente',
        'help' => 'Il tipo di account che stai creando',
      ),
    ),
    'messages' => 
    array (
      'success' => 'Registrazione completata con successo',
      'error' => 'Si è verificato un errore durante la registrazione',
    ),
  ),
  'login' => 
  array (
    'title' => 'Accesso',
    'description' => 'Accedi al tuo account',
    'fields' => 
    array (
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Inserisci la tua email',
      ),
      'password' => 
      array (
        'label' => 'Password',
        'placeholder' => 'Inserisci la tua password',
      ),
      'remember' => 
      array (
        'label' => 'Ricordami',
      ),
    ),
    'actions' => 
    array (
      'login' => 
      array (
        'label' => 'Accedi',
      ),
      'forgot_password' => 
      array (
        'label' => 'Password dimenticata?',
      ),
    ),
    'messages' => 
    array (
      'success' => 'Accesso effettuato con successo',
      'error' => 'Credenziali non valide',
    ),
  ),
  'logout' => 
  array (
    'title' => 'Disconnessione',
    'description' => 'Esci dal tuo account',
    'actions' => 
    array (
      'logout' => 
      array (
        'label' => 'Disconnetti',
      ),
      'confirm' => 
      array (
        'label' => 'Conferma',
      ),
      'cancel' => 
      array (
        'label' => 'Annulla',
      ),
    ),
    'messages' => 
    array (
      'success' => 'Disconnessione effettuata con successo',
      'confirm' => 'Sei sicuro di voler uscire?',
    ),
  ),
  'navigation' => 
  array (
    'name' => 'Widgets',
    'plural' => 'Widgets',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Widgets',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'label' => 'Widgets',
  'plural_label' => 'Widgets (Plurale)',
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
      'label' => 'Crea Widgets',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Widgets',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Widgets',
    ),
  ),
);
