<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Registrazione',
    'plural_label' => 'Registrazione',
    'group' => 'Autenticazione',
    'icon' => 'heroicon-o-user-plus',
    'sort' => 2,
  ),
  'label' => 'Registrazione',
  'plural_label' => 'Registrazione',
  'sections' => 
  array (
    'empty' => 
    array (
      'label' => 'Vuoto',
      'heading' => 'Nessuna sezione',
    ),
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome di battesimo',
      'placeholder' => 'Mario',
      'helper_text' => 'Il tuo nome di battesimo',
      'description' => 'Il tuo nome di battesimo',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome',
      'placeholder' => 'Rossi',
      'helper_text' => 'Il tuo cognome',
      'description' => 'Il tuo cognome',
    ),
    'email' => 
    array (
      'label' => 'Indirizzo Email',
      'tooltip' => 'Email personale',
      'placeholder' => 'mario.rossi@esempio.it',
      'helper_text' => 'Utilizza la tua email migliore per ricevere aggiornamenti.',
      'description' => 'Email personale',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'tooltip' => 'Password di accesso',
      'placeholder' => 'Inserisci una password sicura',
      'helper_text' => 'Minimo 12 caratteri, una maiuscola, un numero e un simbolo.',
      'description' => 'Password di accesso',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'tooltip' => 'Conferma la password',
      'placeholder' => 'Ripeti la password',
      'helper_text' => 'Deve corrispondere alla password inserita sopra.',
      'description' => 'Conferma della password',
    ),
    'privacy_policy_accepted' => 
    array (
      'label' => 'Accetto la Privacy Policy',
      'tooltip' => 'Accetta la privacy policy',
      'helper_text' => 'Obbligatorio per registrarsi.',
      'description' => 'Consenso privacy',
    ),
    'marketing_consent' => 
    array (
      'label' => 'Voglio ricevere aggiornamenti (Marketing)',
      'tooltip' => 'Consenso marketing',
      'helper_text' => 'Facoltativo. Ti invieremo solo cose interessanti!',
      'description' => 'Consenso marketing',
    ),
    'third_party_consent' => 
    array (
      'label' => 'Consenso terze parti',
      'tooltip' => 'Consenso per terze parti',
      'helper_text' => 'Facoltativo.',
      'description' => 'Consenso dati a terzi',
    ),
    'analytics_consent' => 
    array (
      'label' => 'Consenso analisi dati',
      'tooltip' => 'Consenso per analisi',
      'helper_text' => 'Facoltativo.',
      'description' => 'Consenso per analisi',
    ),
    'profiling_consent' => 
    array (
      'label' => 'Consenso profilazione',
      'tooltip' => 'Consenso per profilazione',
      'helper_text' => 'Facoltativo.',
      'description' => 'Consenso per profilazione',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Registrati',
      'tooltip' => 'Crea un nuovo account',
      'helper_text' => 'Registrati al sistema',
      'description' => 'Azione di registrazione',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Registrazione completata con successo',
    'error' => 'Si è verificato un errore',
  ),
);
