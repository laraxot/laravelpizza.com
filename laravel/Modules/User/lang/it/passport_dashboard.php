<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Passport / API',
    'plural_label' => 'Passport / API',
    'group' => 'Sistema',
    'icon' => 'heroicon-o-key',
    'sort' => 95,
  ),
  'label' => 'Passport / API',
  'plural_label' => 'Passport / API',
  'fields' => 
  array (
    'client_id' => 
    array (
      'label' => 'Client ID',
      'placeholder' => 'Inserisci il client ID',
      'help' => 'Identificativo del client OAuth',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'client_secret' => 
    array (
      'label' => 'Client Secret',
      'placeholder' => 'Inserisci il client secret',
      'help' => 'Secret per l\'autenticazione OAuth',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Client',
      'tooltip' => 'Crea un nuovo client OAuth',
    ),
    'revoke' => 
    array (
      'label' => 'Revoca',
      'tooltip' => 'Revoca l\'accesso',
    ),
  ),
  'messages' => 
  array (
    'client_created' => 'Client creato con successo',
    'client_revoked' => 'Client revocato con successo',
  ),
);
