<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Provider Social',
    'plural_label' => 'Provider Social',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-share',
    'sort' => 93,
  ),
  'label' => 'Provider Social',
  'plural_label' => 'Provider Social',
  'resources' => 
  array (
    'label' => 'Risorse',
    'tooltip' => 'Risorse del sistema',
    'helper_text' => 'Risorse disponibili',
    'description' => 'Risorse del sistema',
  ),
  'pages' => 
  array (
    'label' => 'Pagine',
    'tooltip' => 'Pagine del sistema',
    'helper_text' => 'Pagine disponibili',
    'description' => 'Pagine del sistema',
  ),
  'widgets' => 
  array (
    'label' => 'Widgets',
    'tooltip' => 'Widget del sistema',
    'helper_text' => 'Widget disponibili',
    'description' => 'Widgets del sistema',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del provider',
      'placeholder' => 'Inserisci il nome',
      'helper_text' => 'Nome identificativo del provider',
      'description' => 'Nome del provider social',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Nome del guard',
      'placeholder' => 'Seleziona il guard',
      'helper_text' => 'Sistema di autenticazione',
      'description' => 'Nome del guard',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Permessi del provider',
      'placeholder' => 'Seleziona i permessi',
      'helper_text' => 'Permessi associati al provider',
      'description' => 'Permessi del provider',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'tooltip' => 'Data di ultimo aggiornamento',
      'helper_text' => 'Data dell\'ultimo aggiornamento',
      'description' => 'Timestamp di aggiornamento',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome dell\'utente',
      'placeholder' => 'Inserisci il nome',
      'helper_text' => 'Nome dell\'utente',
      'description' => 'Nome di battesimo',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome dell\'utente',
      'placeholder' => 'Inserisci il cognome',
      'helper_text' => 'Cognome dell\'utente',
      'description' => 'Cognome dell\'utente',
    ),
    'select_all' => 
    array (
      'name' => 
      array (
        'label' => 'Seleziona Tutti',
        'tooltip' => 'Seleziona tutti gli elementi',
        'helper_text' => 'Seleziona tutti gli elementi disponibili',
        'description' => 'Azione per selezionare tutto',
      ),
      'message' => 
      array (
        'label' => 'Messaggio',
        'tooltip' => 'Messaggio da mostrare',
        'placeholder' => 'Inserisci un messaggio',
        'helper_text' => 'Messaggio da visualizzare',
        'description' => 'Testo del messaggio',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri',
      'helper_text' => 'Applica i filtri selezionati',
      'description' => 'Azione per applicare i filtri',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'label' => 'Importa',
      'tooltip' => 'Importa dati',
      'helper_text' => 'Importa dati da file esterno',
      'description' => 'Azione per importare',
      'fields' => 
      array (
        'import_file' => 
        array (
          'label' => 'File Import',
          'tooltip' => 'Seleziona un file',
          'placeholder' => 'Seleziona un file XLS o CSV da caricare',
          'helper_text' => 'Seleziona un file XLS o CSV da caricare',
          'description' => 'File contenente i dati',
        ),
      ),
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta dati',
      'helper_text' => 'Esporta i dati in formato CSV/Excel',
      'description' => 'Azione per esportare',
      'filename_prefix' => 
      array (
        'label' => 'Prefisso Nome File',
        'tooltip' => 'Prefisso per il nome',
        'placeholder' => 'Inserisci il prefisso',
        'helper_text' => 'Prefisso per il nome del file',
        'description' => 'Prefisso del file',
      ),
      'columns' => 
      array (
        'name' => 
        array (
          'label' => 'Nome Colonna',
          'tooltip' => 'Nome della colonna',
          'helper_text' => 'Nome della colonna',
          'description' => 'Nome della colonna',
        ),
        'parent_name' => 
        array (
          'label' => 'Nome Padre',
          'tooltip' => 'Nome del livello superiore',
          'helper_text' => 'Nome del parent',
          'description' => 'Nome del parent',
        ),
      ),
    ),
    'create' => 
    array (
      'label' => 'Crea',
      'tooltip' => 'Crea nuovo elemento',
      'helper_text' => 'Crea un nuovo elemento',
      'description' => 'Azione per creare',
      'icon' => 'heroicon-o-plus',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Provider creato con successo',
    'updated' => 'Provider aggiornato con successo',
    'deleted' => 'Provider eliminato con successo',
  ),
);
