<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Cache Lock',
    'plural' => 'Cache Locks',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione dei lock di cache',
    ),
    'label' => 'cache-lock',
    'sort' => '20',
    'icon' => 'xot-lock',
  ),
  'fields' => 
  array (
    'key' => 
    array (
      'label' => 'Chiave',
      'placeholder' => 'Inserisci la chiave del lock',
      'help' => 'Identificativo univoco del lock in cache',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'owner' => 
    array (
      'label' => 'Proprietario',
      'placeholder' => 'Identificativo del proprietario',
      'help' => 'Identificativo del processo che detiene il lock',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expiration' => 
    array (
      'label' => 'Scadenza',
      'placeholder' => 'Timestamp di scadenza',
      'help' => 'Momento in cui il lock scadrà automaticamente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizza',
      'success' => 'Lock visualizzato',
      'error' => 'Impossibile visualizzare il lock',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'success' => 'Lock eliminato con successo',
      'error' => 'Impossibile eliminare il lock',
      'confirm' => 'Sei sicuro di voler eliminare questo lock?',
    ),
    'release' => 
    array (
      'label' => 'Rilascia',
      'success' => 'Lock rilasciato con successo',
      'error' => 'Impossibile rilasciare il lock',
    ),
    'refresh' => 
    array (
      'label' => 'Aggiorna',
      'success' => 'Lock aggiornato',
      'error' => 'Impossibile aggiornare il lock',
    ),
  ),
  'messages' => 
  array (
    'status' => 
    array (
      'active' => 'Lock attivo',
      'expired' => 'Lock scaduto',
      'released' => 'Lock rilasciato',
    ),
    'errors' => 
    array (
      'not_found' => 'Lock non trovato',
      'already_acquired' => 'Lock già acquisito',
      'expired' => 'Lock scaduto',
      'permission' => 'Permessi insufficienti',
    ),
    'warnings' => 
    array (
      'expiring_soon' => 'Il lock scadrà a breve',
      'stale_lock' => 'Lock potenzialmente bloccato',
    ),
    'info' => 
    array (
      'auto_release' => 'Il lock verrà rilasciato automaticamente alla scadenza',
      'lock_extended' => 'Durata del lock estesa',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
