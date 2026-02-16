<?php

declare(strict_types=1);

return array (
  'pages' => 'Pagine',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Importazione',
    'plural' => 'Importazioni',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione delle importazioni di dati',
    ),
    'label' => 'Importazione Dati',
    'sort' => '10',
    'icon' => 'job-import',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo unico dell\'importazione',
      'placeholder' => 'ID Importazione',
      'helper_text' => '',
      'description' => '',
    ),
    'file' => 
    array (
      'label' => 'File',
      'tooltip' => 'Seleziona il file da importare',
      'placeholder' => 'Scegli un file',
      'helper_text' => '',
      'description' => '',
    ),
    'source' => 
    array (
      'label' => 'Sorgente',
      'tooltip' => 'Indica la sorgente del file importato',
      'placeholder' => 'Sorgente del file',
      'helper_text' => '',
      'description' => '',
    ),
    'format' => 
    array (
      'label' => 'Formato',
      'tooltip' => 'Formato del file importato (CSV, Excel, etc.)',
      'placeholder' => 'Seleziona formato',
      'helper_text' => '',
      'description' => '',
    ),
    'rows' => 
    array (
      'label' => 'Righe',
      'tooltip' => 'Numero totale di righe nel file',
      'placeholder' => 'Numero righe',
      'helper_text' => '',
      'description' => '',
    ),
    'processed' => 
    array (
      'label' => 'Righe Processate',
      'tooltip' => 'Numero di righe processate con successo',
      'placeholder' => 'Righe processate',
      'helper_text' => '',
      'description' => '',
    ),
    'failed' => 
    array (
      'label' => 'Righe Fallite',
      'tooltip' => 'Numero di righe che hanno causato errore durante l\'importazione',
      'placeholder' => 'Righe fallite',
      'helper_text' => '',
      'description' => '',
    ),
    'started_at' => 
    array (
      'label' => 'Iniziato il',
      'tooltip' => 'Data e ora di inizio dell\'importazione',
      'placeholder' => 'Data inizio importazione',
      'helper_text' => '',
      'description' => '',
    ),
    'completed_at' => 
    array (
      'label' => 'Completato il',
      'tooltip' => 'Data e ora di completamento dell\'importazione',
      'placeholder' => 'Data completamento importazione',
      'helper_text' => '',
      'description' => '',
    ),
    'options' => 
    array (
      'label' => 'Opzioni',
      'tooltip' => 'Impostazioni avanzate per l\'importazione',
      'placeholder' => 'Seleziona le opzioni',
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
  ),
  'formats' => 
  array (
    'csv' => 'CSV',
    'excel' => 'Excel',
    'json' => 'JSON',
    'xml' => 'XML',
  ),
  'options' => 
  array (
    'headers' => 'Prima riga contiene intestazioni',
    'delimiter' => 'Delimitatore',
    'encoding' => 'Codifica',
    'sheet' => 'Foglio di lavoro',
    'chunk_size' => 'Dimensione chunk',
  ),
  'actions' => 
  array (
    'upload' => 
    array (
      'label' => 'Carica File',
      'modal' => 
      array (
        'heading' => 'Carica un file da importare',
        'description' => 'Seleziona un file dal tuo computer',
      ),
      'messages' => 
      array (
        'success' => 'File caricato con successo',
      ),
      'icon' => 'upload',
      'color' => 'primary',
    ),
    'start' => 
    array (
      'label' => 'Avvia Importazione',
      'modal' => 
      array (
        'heading' => 'Avvia Importazione',
        'description' => 'Avvia il processo di importazione del file selezionato',
      ),
      'messages' => 
      array (
        'success' => 'Importazione avviata con successo',
      ),
      'icon' => 'play-circle',
      'color' => 'success',
    ),
    'download_template' => 
    array (
      'label' => 'Scarica Template',
      'modal' => 
      array (
        'heading' => 'Scarica Template',
        'description' => 'Scarica il template per caricare i dati',
      ),
      'messages' => 
      array (
        'success' => 'Template scaricato con successo',
      ),
      'icon' => 'file-download',
      'color' => 'info',
    ),
    'download_failed' => 
    array (
      'label' => 'Scarica Righe Fallite',
      'modal' => 
      array (
        'heading' => 'Scarica Righe Fallite',
        'description' => 'Scarica un file con tutte le righe che hanno causato errori',
      ),
      'messages' => 
      array (
        'success' => 'Righe fallite scaricate con successo',
      ),
      'icon' => 'download-error',
      'color' => 'danger',
    ),
    'import' => 
    array (
      'label' => 'Importa',
      'modal' => 
      array (
        'heading' => 'Importa Dati',
        'description' => 'Seleziona un file da importare',
      ),
      'messages' => 
      array (
        'success' => 'Importazione avviata con successo',
      ),
      'fields' => 
      array (
        'import_file' => 
        array (
          'label' => 'Seleziona un file XLS o CSV da caricare',
          'tooltip' => 'Seleziona il file che desideri importare',
          'placeholder' => 'Carica un file XLS o CSV',
        ),
      ),
      'icon' => 'import',
      'color' => 'primary',
    ),
    'retry' => 
    array (
      'label' => 'Riprova',
      'modal' => 
      array (
        'heading' => 'Riprova Importazione',
        'description' => 'Vuoi riprovare l\'importazione delle righe fallite?',
      ),
      'messages' => 
      array (
        'success' => 'Importazione riprovata con successo',
      ),
      'icon' => 'redo',
      'color' => 'warning',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal' => 
      array (
        'heading' => 'Elimina Import',
        'description' => 'Sei sicuro di voler eliminare questa importazione?',
      ),
      'messages' => 
      array (
        'success' => 'Import eliminato con successo',
      ),
      'icon' => 'trash',
      'color' => 'danger',
    ),
    'download_errors' => 
    array (
      'label' => 'Scarica Errori',
      'modal' => 
      array (
        'heading' => 'Scarica Log Errori',
        'description' => 'Vuoi scaricare il log degli errori di importazione?',
      ),
      'messages' => 
      array (
        'success' => 'Log errori scaricato con successo',
      ),
      'icon' => 'file-text',
      'color' => 'secondary',
    ),
    'export' => 
    array (
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 'Nome area',
        'parent_name' => 'Nome area livello superiore',
      ),
    ),
  ),
  'messages' => 
  array (
    'no_imports' => 'Nessuna importazione presente',
    'upload_success' => 'File caricato con successo',
    'import_started' => 'Importazione avviata',
    'import_completed' => 'Importazione completata',
    'import_failed' => 'Importazione fallita',
    'file_not_found' => 'File non trovato',
    'invalid_format' => 'Formato non valido',
    'row_error' => 'Errore alla riga :row: :message',
  ),
  'statuses' => 
  array (
    'pending' => 'In Attesa',
    'processing' => 'In Elaborazione',
    'completed' => 'Completato',
    'failed' => 'Fallito',
    'partial' => 'Completato Parzialmente',
  ),
  'types' => 
  array (
    'csv' => 'CSV',
    'excel' => 'Excel',
    'json' => 'JSON',
    'xml' => 'XML',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
