<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Codici Autorizzazione OAuth',
    'plural_label' => 'Codici Autorizzazione OAuth',
    'group' => 'OAuth',
    'icon' => 'heroicon-o-code-bracket',
    'sort' => 31,
  ),
  'label' => 'Codice Autorizzazione OAuth',
  'plural_label' => 'Codici Autorizzazione OAuth',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco',
      'helper_text' => 'Identificativo numerico del codice',
      'description' => 'ID del codice',
    ),
    'user_id' => 
    array (
      'label' => 'Utente',
      'tooltip' => 'Utente associato',
      'placeholder' => 'Seleziona l\'utente',
      'helper_text' => 'Utente proprietario del codice',
      'description' => 'ID dell\'utente',
    ),
    'client_id' => 
    array (
      'label' => 'Client',
      'tooltip' => 'Client OAuth',
      'placeholder' => 'Seleziona il client',
      'helper_text' => 'Client che ha generato il codice',
      'description' => 'ID del client OAuth',
    ),
    'scopes' => 
    array (
      'label' => 'Ambiti',
      'tooltip' => 'Permessi del codice',
      'placeholder' => 'Seleziona gli ambiti',
      'helper_text' => 'Ambiti di permesso',
      'description' => 'Permessi associati al codice',
    ),
    'revoked' => 
    array (
      'label' => 'Revocato',
      'tooltip' => 'Stato di revoca',
      'helper_text' => 'Indica se il codice è stato revocato',
      'description' => 'Stato di revoca',
    ),
    'expires_at' => 
    array (
      'label' => 'Scade il',
      'tooltip' => 'Data di scadenza',
      'placeholder' => 'Seleziona la data',
      'helper_text' => 'Data e ora di scadenza del codice',
      'description' => 'Data di scadenza',
    ),
  ),
  'actions' => 
  array (
    'revoke' => 
    array (
      'label' => 'Revoca',
      'tooltip' => 'Revoca il codice',
      'helper_text' => 'Revoca questo codice',
      'description' => 'Azione per revocare il codice',
      'success' => 'Codice di autorizzazione revocato con successo',
    ),
  ),
  'messages' => 
  array (
    'revoked' => 'Codice revocato con successo',
  ),
);
