<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Sessioni',
    'plural' => 'Sessioni',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione delle sessioni utente e sicurezza',
    ),
    'label' => 'session',
    'sort' => '18',
    'icon' => 'xot-session',
  ),
  'fields' => 
  array (
    'identification' => 
    array (
      'id' => 
      array (
        'label' => 'ID Sessione',
        'help' => 'Identificativo univoco della sessione',
      ),
      'user_id' => 
      array (
        'label' => 'Utente',
        'placeholder' => 'Seleziona l\'utente',
        'help' => 'Utente proprietario della sessione',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'connection' => 
    array (
      'ip_address' => 
      array (
        'label' => 'Indirizzo IP',
        'help' => 'IP di origine della connessione',
      ),
      'user_agent' => 
      array (
        'label' => 'User Agent',
        'help' => 'Browser e sistema operativo utilizzati',
      ),
      'location' => 
      array (
        'label' => 'Posizione',
        'help' => 'Localizzazione geografica approssimativa',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'data' => 
    array (
      'payload' => 
      array (
        'label' => 'Dati Sessione',
        'help' => 'Contenuto della sessione (criptato)',
      ),
      'size' => 
      array (
        'label' => 'Dimensione',
        'help' => 'Dimensione dei dati in memoria',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timing' => 
    array (
      'created_at' => 
      array (
        'label' => 'Data Creazione',
        'help' => 'Momento di inizio della sessione',
      ),
      'last_activity' => 
      array (
        'label' => 'Ultima Attività',
        'help' => 'Ultimo accesso alla sessione',
      ),
      'expires_at' => 
      array (
        'label' => 'Scadenza',
        'help' => 'Momento di scadenza previsto',
      ),
      'label' => '',
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
      'success' => 'Dettagli sessione visualizzati',
      'error' => 'Impossibile visualizzare la sessione',
    ),
    'delete' => 
    array (
      'label' => 'Termina',
      'success' => 'Sessione terminata con successo',
      'error' => 'Impossibile terminare la sessione',
      'confirm' => 'Sei sicuro di voler terminare questa sessione?',
    ),
    'delete_all' => 
    array (
      'label' => 'Termina Tutte',
      'success' => 'Tutte le sessioni terminate',
      'error' => 'Impossibile terminare tutte le sessioni',
      'confirm' => 'Sei sicuro di voler terminare tutte le sessioni?',
    ),
    'delete_expired' => 
    array (
      'label' => 'Pulisci Scadute',
      'success' => 'Sessioni scadute rimosse',
      'error' => 'Impossibile rimuovere le sessioni scadute',
    ),
    'refresh' => 
    array (
      'label' => 'Aggiorna',
      'success' => 'Elenco sessioni aggiornato',
      'error' => 'Impossibile aggiornare l\'elenco',
    ),
  ),
  'messages' => 
  array (
    'status' => 
    array (
      'active' => 'Sessione attiva',
      'expired' => 'Sessione scaduta',
      'idle' => 'Sessione inattiva',
      'terminated' => 'Sessione terminata',
    ),
    'errors' => 
    array (
      'not_found' => 'Sessione non trovata',
      'invalid' => 'Sessione non valida',
      'expired' => 'Sessione scaduta',
      'permission' => 'Permessi insufficienti',
      'delete_current' => 'Impossibile terminare la sessione corrente',
    ),
    'warnings' => 
    array (
      'delete_current' => 'Stai per terminare la tua sessione attuale',
      'delete_all' => 'Tutti gli utenti verranno disconnessi',
      'inactivity' => 'La sessione scadrà tra poco per inattività',
      'multiple_sessions' => 'Rilevate sessioni multiple per lo stesso utente',
    ),
    'info' => 
    array (
      'cleanup_scheduled' => 'Pulizia automatica programmata',
      'session_extended' => 'Durata sessione estesa',
      'activity_detected' => 'Rilevata nuova attività',
    ),
  ),
  'settings' => 
  array (
    'lifetime' => 
    array (
      'label' => 'Durata Sessione',
      'help' => 'Tempo massimo di inattività',
      'options' => 
      array (
        120 => '2 ore',
        240 => '4 ore',
        480 => '8 ore',
        720 => '12 ore',
        1440 => '1 giorno',
        10080 => '1 settimana',
      ),
    ),
    'security' => 
    array (
      'secure' => 
      array (
        'label' => 'HTTPS Obbligatorio',
        'help' => 'Richiedi connessione sicura',
      ),
      'same_site' => 
      array (
        'label' => 'Politica Same Site',
        'help' => 'Restrizioni di accesso ai cookie',
        'options' => 
        array (
          'lax' => 'Lax (consigliato)',
          'strict' => 'Strict (più sicuro)',
          'none' => 'Nessuna (meno sicuro)',
        ),
      ),
      'http_only' => 
      array (
        'label' => 'Solo HTTP',
        'help' => 'Previeni accesso JavaScript',
      ),
    ),
    'storage' => 
    array (
      'driver' => 
      array (
        'label' => 'Driver',
        'help' => 'Sistema di memorizzazione',
        'options' => 
        array (
          'file' => 'File System',
          'redis' => 'Redis',
          'database' => 'Database',
          'array' => 'Array (test)',
        ),
      ),
      'cleanup' => 
      array (
        'label' => 'Pulizia Automatica',
        'help' => 'Rimozione sessioni scadute',
      ),
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
