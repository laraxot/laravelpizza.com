<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Allegati',
    'group' => 'Contenuti',
    'icon' => 'heroicon-o-paper-clip',
    'sort' => 89,
  ),
  'fields' => 
  array (
    'attachment' => 
    array (
      'label' => 'File',
      'placeholder' => 'Seleziona un file',
      'helper_text' => 'Carica un nuovo file o selezionalo dalla libreria',
      'description' => 'I file supportati sono: PDF, documenti Word, Excel, immagini e archivi ZIP',
      'tooltip' => '',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo',
      'helper_text' => 'Inserisci un titolo descrittivo per questo allegato',
      'description' => 'Il titolo verrà mostrato nell\'elenco degli allegati',
      'tooltip' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'slug-del-file',
      'helper_text' => 'Identificativo univoco per il file',
      'description' => 'Lo slug verrà generato automaticamente dal titolo',
      'tooltip' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data di creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima modifica',
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
    'delete' => 
    array (
      'label' => 'delete',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'edit' => 
    array (
      'label' => 'edit',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'view' => 
    array (
      'label' => 'view',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'layout' => 
    array (
      'label' => 'layout',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'create' => 
    array (
      'label' => 'create',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'description' => 'description',
      'label' => 'description',
      'placeholder' => 'description',
      'helper_text' => 'description',
      'tooltip' => '',
    ),
    'disk' => 
    array (
      'description' => 'disk',
      'label' => 'disk',
      'placeholder' => 'disk',
      'helper_text' => 'disk',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Nuovo allegato',
    'edit' => 'Modifica allegato',
    'delete' => 'Elimina allegato',
    'view' => 'Visualizza allegato',
    'download' => 'Scarica file',
    'activeLocale' => 
    array (
      'label' => 'activeLocale',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Allegato creato con successo',
    'updated' => 'Allegato aggiornato con successo',
    'deleted' => 'Allegato eliminato con successo',
    'delete_confirm' => 'Sei sicuro di voler eliminare questo allegato?',
    'file_too_large' => 'Il file è troppo grande. Dimensione massima consentita: :size MB',
    'file_type_not_allowed' => 'Tipo di file non consentito',
  ),
  'filters' => 
  array (
    'search' => 'Cerca allegati...',
    'all' => 'Tutti gli allegati',
    'type' => 
    array (
      'label' => 'Tipo di file',
      'options' => 
      array (
        'all' => 'Tutti i tipi',
        'image' => 'Immagini',
        'document' => 'Documenti',
        'spreadsheet' => 'Fogli di calcolo',
        'archive' => 'Archivi',
        'other' => 'Altro',
      ),
    ),
    'date' => 
    array (
      'label' => 'Data',
      'options' => 
      array (
        'today' => 'Oggi',
        'week' => 'Questa settimana',
        'month' => 'Questo mese',
        'year' => 'Quest\'anno',
        'all' => 'Tutte le date',
      ),
    ),
  ),
  'table' => 
  array (
    'columns' => 
    array (
      'title' => 'Titolo',
      'type' => 'Tipo',
      'size' => 'Dimensione',
      'created_at' => 'Caricato il',
      'actions' => 'Azioni',
    ),
    'empty' => 'Nessun allegato trovato',
    'search' => 'Cerca allegati...',
    'actions' => 
    array (
      'edit' => 'Modifica',
      'delete' => 'Elimina',
      'download' => 'Scarica',
      'view' => 'Visualizza',
    ),
  ),
  'sections' => 
  array (
    'details' => 
    array (
      'label' => 'Dettagli allegato',
      'description' => 'Gestisci le informazioni di base dell\'allegato',
    ),
    'file' => 
    array (
      'label' => 'File',
      'description' => 'Carica o seleziona un file',
    ),
    'empty' => 
    array (
      'heading' => 'empty',
      'label' => 'empty',
    ),
  ),
  'empty' => 
  array (
    'label' => 'Nessun contenuto',
    'heading' => 'Nessun allegato presente',
  ),
  'model' => 
  array (
    'label' => 'attachment.model',
  ),
  'label' => 'Attachment',
  'plural_label' => 'Attachment (Plurale)',
);
