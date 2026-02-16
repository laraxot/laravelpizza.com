<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Refresh Token OAuth',
    'plural_label' => 'Refresh Token OAuth',
    'group' => 'OAuth',
    'icon' => 'heroicon-o-arrow-path',
    'sort' => 27,
  ),
  'label' => 'Refresh Token OAuth',
  'plural_label' => 'Refresh Token OAuth',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco',
      'helper_text' => 'Identificativo numerico del token',
      'description' => 'ID del refresh token',
    ),
    'access_token_id' => 
    array (
      'label' => 'Token Accesso',
      'tooltip' => 'Token di accesso associato',
      'placeholder' => 'Seleziona il token',
      'helper_text' => 'Token di accesso associato a questo refresh token',
      'description' => 'ID del token di accesso',
    ),
    'revoked' => 
    array (
      'label' => 'Revocato',
      'tooltip' => 'Stato di revoca',
      'helper_text' => 'Indica se il token è stato revocato',
      'description' => 'Stato di revoca del token',
    ),
    'expires_at' => 
    array (
      'label' => 'Scade il',
      'tooltip' => 'Data di scadenza',
      'placeholder' => 'Seleziona la data',
      'helper_text' => 'Data e ora di scadenza del token',
      'description' => 'Data di scadenza',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => 'Data di creazione',
      'helper_text' => 'Data e ora di creazione del token',
      'description' => 'Timestamp di creazione',
    ),
  ),
  'actions' => 
  array (
    'revoke' => 
    array (
      'label' => 'Revoca',
      'tooltip' => 'Revoca il token',
      'helper_text' => 'Revoca questo refresh token',
      'description' => 'Azione per revocare',
      'success' => 'Refresh token revocato con successo',
    ),
  ),
  'messages' => 
  array (
    'revoked' => 'Refresh token revocato con successo',
  ),
);
