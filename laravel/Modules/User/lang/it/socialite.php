<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Accesso con social',
    'plural_label' => 'Accesso con social',
    'group' => 'Autenticazione',
    'icon' => 'heroicon-o-share',
    'sort' => 90,
  ),
  'label' => 'Accesso con social',
  'plural_label' => 'Accesso con social',
  'fields' => 
  array (
    'provider' => 
    array (
      'label' => 'Provider',
      'placeholder' => 'Seleziona il provider',
      'help' => 'Provider OAuth per l\'accesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'provider_id' => 
    array (
      'label' => 'Provider ID',
      'placeholder' => 'Inserisci l\'ID del provider',
      'help' => 'Identificativo utente sul provider',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token' => 
    array (
      'label' => 'Token',
      'placeholder' => 'Token di accesso',
      'help' => 'Token OAuth per l\'accesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'connect' => 
    array (
      'label' => 'Connetti',
      'tooltip' => 'Connetti account social',
    ),
    'disconnect' => 
    array (
      'label' => 'Disconnetti',
      'tooltip' => 'Disconnetti account social',
    ),
  ),
  'messages' => 
  array (
    'connected' => 'Account social connesso con successo',
    'disconnected' => 'Account social disconnesso con successo',
  ),
);
