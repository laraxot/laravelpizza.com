<?php

declare(strict_types=1);

return [
  'sections' => [
    'empty' => [
      'label' => 'empty',
      'heading' => 'empty',
    ],
  ],
  'fields' => [
    'first_name' => [
      'label' => 'Nome',
      'placeholder' => 'Mario',
      'helper_text' => '',
      'description' => 'Il tuo nome di battesimo',
    ],
    'last_name' => [
      'label' => 'Cognome',
      'placeholder' => 'Rossi',
      'helper_text' => '',
      'description' => 'Il tuo cognome',
    ],
    'email' => [
      'label' => 'Indirizzo Email',
      'placeholder' => 'mario.rossi@esempio.it',
      'helper_text' => 'Utilizza la tua email migliore per ricevere aggiornamenti.',
      'description' => 'Email personale',
    ],
    'password' => [
      'label' => 'Password',
      'placeholder' => 'Inserisci una password sicura',
      'helper_text' => 'Minimo 12 caratteri, una maiuscola, un numero e un simbolo.',
      'description' => 'Password di accesso',
    ],
    'password_confirmation' => [
      'label' => 'Conferma Password',
      'placeholder' => 'Ripeti la password',
      'helper_text' => 'Deve corrispondere alla password inserita sopra.',
      'description' => 'Conferma della password',
    ],
    'privacy_policy_accepted' => [
      'label' => 'Accetto la Privacy Policy',
      'placeholder' => '',
      'helper_text' => 'Obbligatorio per registrarsi.',
      'description' => 'Consenso privacy',
    ],
    'marketing_consent' => [
      'label' => 'Voglio ricevere aggiornamenti (Marketing)',
      'placeholder' => '',
      'helper_text' => 'Facoltativo. Ti invieremo solo cose interessanti!',
      'description' => 'Consenso marketing',
    ],
    'third_party_consent' => [
      'label' => 'Consenso terze parti',
      'placeholder' => '',
      'helper_text' => 'Facoltativo.',
      'description' => 'Consenso dati a terzi',
    ],
    'analytics_consent' => [
      'label' => 'Consenso analisi dati',
      'placeholder' => '',
      'helper_text' => 'Facoltativo.',
      'description' => 'Consenso per analisi',
    ],
    'profiling_consent' => [
      'label' => 'Consenso profilazione',
      'helper_text' => 'Facoltativo.',
      'description' => 'Consenso per profilazione',
    ],
  ],
  'label' => 'Register Widget',
  'plural_label' => 'Register Widget (Plurale)',
  'navigation' => [
    'name' => 'Register Widget',
    'plural' => 'Register Widget',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Register Widget',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'actions' => [
    'create' => [
      'label' => 'Crea Register Widget',
    ],
    'edit' => [
      'label' => 'Modifica Register Widget',
    ],
    'delete' => [
      'label' => 'Elimina Register Widget',
    ],
  ],
];
