<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Token Accesso OAuth',
    'plural_label' => 'Token Accesso OAuth',
    'group' => 'OAuth',
    'icon' => 'heroicon-o-key',
    'sort' => 33,
  ),
  'label' => 'Token Accesso OAuth',
  'plural_label' => 'Token Accesso OAuth',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco',
      'helper_text' => 'Identificativo numerico del token',
      'description' => 'ID del token',
    ),
    'user_id' => 
    array (
      'label' => 'Utente',
      'tooltip' => 'Utente associato',
      'placeholder' => 'Seleziona l\'utente',
      'helper_text' => 'Utente proprietario del token',
      'description' => 'ID dell\'utente',
    ),
    'client_id' => 
    array (
      'label' => 'Client',
      'tooltip' => 'Client OAuth',
      'placeholder' => 'Seleziona il client',
      'helper_text' => 'Client che ha generato il token',
      'description' => 'ID del client OAuth',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del token',
      'placeholder' => 'Inserisci il nome',
      'helper_text' => 'Nome identificativo del token',
      'description' => 'Nome del token',
    ),
    'scopes' => 
    array (
      'label' => 'Ambiti',
      'tooltip' => 'Permessi del token',
      'placeholder' => 'Seleziona gli ambiti',
      'helper_text' => 'Ambiti di permesso del token',
      'description' => 'Permessi associati al token',
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
    'user' => 
    array (
      'name' => 
      array (
        'label' => 'Nome Utente',
        'tooltip' => 'Nome dell\'utente',
        'helper_text' => 'Nome dell\'utente proprietario',
        'description' => 'Nome utente',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'client' => 
    array (
      'name' => 
      array (
        'label' => 'Nome Client',
        'tooltip' => 'Nome del client',
        'helper_text' => 'Nome del client OAuth',
        'description' => 'Nome client',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => 'Data di creazione',
      'helper_text' => 'Data e ora di creazione del token',
      'description' => 'Data di creazione',
    ),
    'expired' => 
    array (
      'label' => 'Scaduto',
      'tooltip' => 'Stato di scadenza',
      'helper_text' => 'Indica se il token è scaduto',
      'description' => 'Stato di scadenza',
    ),
    'valid' => 
    array (
      'label' => 'Valido',
      'tooltip' => 'Validità del token',
      'helper_text' => 'Indica se il token è valido',
      'description' => 'Stato di validità',
    ),
  ),
  'actions' => 
  array (
    'revoke' => 
    array (
      'label' => 'Revoca',
      'tooltip' => 'Revoca il token',
      'helper_text' => 'Revoca questo token',
      'description' => 'Azione per revocare il token',
    ),
    'refresh' => 
    array (
      'label' => 'Aggiorna',
      'tooltip' => 'Aggiorna il token',
      'helper_text' => 'Aggiorna questo token',
      'description' => 'Azione per aggiornare il token',
    ),
    'revoke_all_for_user' => 
    array (
      'label' => 'Revoca Tutti',
      'tooltip' => 'Revoca tutti i token per questo utente',
      'helper_text' => 'Revoca tutti i token dell\'utente',
      'description' => 'Revoca tutti i token per utente',
      'success' => ':count token revocati con successo.',
    ),
    'logout' => 
    array (
      'label' => 'Logout',
      'tooltip' => 'Disconnettiti',
      'helper_text' => 'Esci dall\'account',
      'description' => 'Azione di logout',
      'icon' => 'heroicon-o-arrow-right-on-rectangle',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina il token',
      'helper_text' => 'Elimina definitivamente il token',
      'description' => 'Azione per eliminare',
      'icon' => 'heroicon-o-trash',
    ),
    'create' => 
    array (
      'label' => 'Crea',
      'tooltip' => 'Crea un nuovo token',
      'helper_text' => 'Crea un nuovo token',
      'description' => 'Azione per creare',
      'icon' => 'heroicon-o-plus',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Token creato con successo',
    'revoked' => 'Token revocato con successo',
    'deleted' => 'Token eliminato con successo',
  ),
);
