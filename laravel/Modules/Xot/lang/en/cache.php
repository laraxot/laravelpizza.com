<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Cache',
    'plural' => 'Cache',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione della cache del sistema',
    ),
    'label' => 'cache',
    'sort' => '29',
    'icon' => 'xot-cache',
  ),
  'fields' => 
  array (
    'key' => 
    array (
      'label' => 'Chiave',
      'placeholder' => 'Inserisci la chiave',
      'help' => 'Chiave identificativa della cache',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'value' => 
    array (
      'label' => 'Valore',
      'placeholder' => 'Inserisci il valore',
      'help' => 'Valore memorizzato nella cache',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ttl' => 
    array (
      'label' => 'Tempo di Vita',
      'placeholder' => 'Inserisci il TTL in minuti',
      'help' => 'Tempo di permanenza in cache (in minuti)',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'tags' => 
    array (
      'label' => 'Tag',
      'placeholder' => 'Seleziona i tag',
      'help' => 'Tag per raggruppare elementi della cache',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'size' => 
    array (
      'label' => 'Dimensione',
      'help' => 'Dimensione occupata in memoria',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Driver',
      'help' => 'Driver di cache utilizzato',
      'options' => 
      array (
        'file' => 'File System',
        'redis' => 'Redis',
        'memcached' => 'Memcached',
        'array' => 'Array',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'help' => 'Data di inserimento in cache',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires_at' => 
    array (
      'label' => 'Data Scadenza',
      'help' => 'Data di scadenza della cache',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'clear' => 
    array (
      'label' => 'Svuota Cache',
      'success' => 'Cache svuotata con successo',
      'error' => 'Errore durante lo svuotamento della cache',
    ),
    'refresh' => 
    array (
      'label' => 'Aggiorna',
      'success' => 'Cache aggiornata con successo',
      'error' => 'Errore durante l\'aggiornamento della cache',
    ),
    'optimize' => 
    array (
      'label' => 'Ottimizza',
      'success' => 'Cache ottimizzata con successo',
      'error' => 'Errore durante l\'ottimizzazione della cache',
    ),
    'warm' => 
    array (
      'label' => 'Preriscalda',
      'success' => 'Cache preriscaldata con successo',
      'error' => 'Errore durante il preriscaldamento della cache',
    ),
  ),
  'messages' => 
  array (
    'validation' => 
    array (
      'key' => 
      array (
        'required' => 'La chiave è obbligatoria',
        'unique' => 'Questa chiave è già presente in cache',
      ),
      'ttl' => 
      array (
        'numeric' => 'Il TTL deve essere un numero',
        'min' => 'Il TTL deve essere maggiore di zero',
      ),
    ),
    'errors' => 
    array (
      'driver_not_supported' => 'Driver di cache non supportato',
      'key_not_found' => 'Chiave non trovata in cache',
      'storage_full' => 'Spazio cache esaurito',
      'connection_failed' => 'Connessione al server cache fallita',
    ),
    'info' => 
    array (
      'auto_cleanup' => 'Gli elementi scaduti verranno rimossi automaticamente',
      'memory_usage' => 'Utilizzo memoria cache: :usage',
      'hit_ratio' => 'Rapporto hit/miss: :ratio',
    ),
  ),
  'pages' => 
  array (
    'health_check_results' => 
    array (
      'buttons' => 
      array (
        'refresh' => 'Aggiorna',
      ),
      'heading' => 'Stato del Sistema',
      'navigation' => 
      array (
        'group' => 'Impostazioni',
        'label' => 'Stato del Sistema',
      ),
      'notifications' => 
      array (
        'check_results' => 'Risultati verifica da',
      ),
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
